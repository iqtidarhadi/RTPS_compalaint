<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Connection extends Model
{
    protected $table = 'connections';
    
    protected $fillable = [
        'flow_id', 'connection_id', 'from_node_id', 
        'to_node_id', 'label', 'connection_type', 'style'
    ];
    
    protected $casts = [
        'style' => 'array',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($connection) {
            if (empty($connection->connection_id)) {
                $connection->connection_id = 'conn_' . Str::uuid()->toString();
            }
        });
    }
    
    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }
    
    public function fromNode()
    {
        return $this->belongsTo(Node::class, 'from_node_id', 'node_id');
    }
    
    public function toNode()
    {
        return $this->belongsTo(Node::class, 'to_node_id', 'node_id');
    }
}