<?php

namespace Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flow extends Model
{
    protected $fillable = ['name','color_theme', 'description', 'color_theme'];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function nodes(): HasMany
    {
        return $this->hasMany(Node::class);
    }
    
    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class);
    }
    
    public function duplicate(): Flow
    {
        $newFlow = $this->replicate();
        $newFlow->name = $this->name . ' (Copy)';
        $newFlow->save();
        
        // Map old node_ids to new node_ids
        $nodeIdMap = [];
        
        foreach ($this->nodes as $node) {
            $oldNodeId = $node->node_id;
            $newNode = $node->replicate();
            $newNode->flow_id = $newFlow->id;
            $newNode->node_id = 'node_' . \Illuminate\Support\Str::uuid()->toString();
            $newNode->save();
            $nodeIdMap[$oldNodeId] = $newNode->node_id;
        }
        
        foreach ($this->connections as $connection) {
            $newConnection = $connection->replicate();
            $newConnection->flow_id = $newFlow->id;
            $newConnection->connection_id = 'conn_' . \Illuminate\Support\Str::uuid()->toString();
            $newConnection->from_node_id = $nodeIdMap[$connection->from_node_id] ?? $connection->from_node_id;
            $newConnection->to_node_id = $nodeIdMap[$connection->to_node_id] ?? $connection->to_node_id;
            $newConnection->save();
        }
        
        return $newFlow;
    }
}