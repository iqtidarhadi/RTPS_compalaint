<?php

namespace Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Node extends Model
{
    protected $table = 'nodes';
    
    protected $fillable = [
        'flow_id', 'node_id', 'node_type', 'label', 
        'position_x', 'position_y', 'width', 'height', 'metadata'
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'position_x' => 'float',
        'position_y' => 'float',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($node) {
            if (empty($node->node_id)) {
                $node->node_id = 'node_' . Str::uuid()->toString();
            }
        });
    }
    
    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }
    
    public function outgoingConnections()
    {
        return $this->hasMany(Connection::class, 'from_node_id', 'node_id');
    }
    
    public function incomingConnections()
    {
        return $this->hasMany(Connection::class, 'to_node_id', 'node_id');
    }
}