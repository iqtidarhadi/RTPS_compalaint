<?php

namespace Database\Seeders;

use App\Models\Flow;
use App\Models\Node;
use App\Models\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FlowchartSeeder extends Seeder
{
    public function run(): void
    {
        $defaultFlow = Flow::create([
            'name' => 'RTS Process Flow - Default',
            'description' => 'Right to Service Act complete process flowchart',
        ]);
        
        // Create nodes with proper node_id values
        $citizen = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_citizen_1',
            'node_type' => 'citizen',
            'label' => 'Citizen',
            'position_x' => 50,
            'position_y' => 200,
            'width' => 180,
            'height' => 78,
        ]);
        
        $servicePoint = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_service_1',
            'node_type' => 'service-point',
            'label' => 'Service Point',
            'position_x' => 300,
            'position_y' => 200,
            'width' => 180,
            'height' => 78,
        ]);
        
        $appellate = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_appellate_1',
            'node_type' => 'appellate-auth',
            'label' => 'Appellate Authority S6(1)',
            'position_x' => 300,
            'position_y' => 380,
            'width' => 220,
            'height' => 78,
        ]);
        
        $rtsComm = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_rts_1',
            'node_type' => 'rts-commission',
            'label' => 'RTS Commission S6(1) & 24',
            'position_x' => 600,
            'position_y' => 380,
            'width' => 250,
            'height' => 78,
        ]);
        
        $investigate = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_investigate_1',
            'node_type' => 'investigate',
            'label' => 'Investigate S6(2)',
            'position_x' => 600,
            'position_y' => 550,
            'width' => 200,
            'height' => 78,
        ]);
        
        $validJust = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_valid_1',
            'node_type' => 'valid-justification',
            'label' => 'Valid Justification S6(3)',
            'position_x' => 350,
            'position_y' => 600,
            'width' => 210,
            'height' => 78,
        ]);
        
        $invalidJust = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_invalid_1',
            'node_type' => 'invalid-justification',
            'label' => 'Invalid Justification S6(3)',
            'position_x' => 850,
            'position_y' => 600,
            'width' => 210,
            'height' => 78,
        ]);
        
        $validS12 = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_valids12_1',
            'node_type' => 'valid-justification-s12',
            'label' => 'Valid Justification S12',
            'position_x' => 200,
            'position_y' => 750,
            'width' => 200,
            'height' => 78,
        ]);
        
        $invalidS12 = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_invalids12_1',
            'node_type' => 'invalid-justification-s12',
            'label' => 'Invalid Justification S12',
            'position_x' => 700,
            'position_y' => 750,
            'width' => 200,
            'height' => 78,
        ]);
        
        $servicePenalty = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_penalty_1',
            'node_type' => 'service-penalty',
            'label' => 'Service Provided & Penalty',
            'position_x' => 200,
            'position_y' => 900,
            'width' => 220,
            'height' => 78,
        ]);
        
        $reject = Node::create([
            'flow_id' => $defaultFlow->id,
            'node_id' => 'node_reject_1',
            'node_type' => 'reject',
            'label' => 'Reject',
            'position_x' => 700,
            'position_y' => 900,
            'width' => 180,
            'height' => 78,
        ]);
        
        // Create connections
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_1',
            'from_node_id' => $citizen->node_id,
            'to_node_id' => $servicePoint->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_2',
            'from_node_id' => $servicePoint->node_id,
            'to_node_id' => $appellate->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_3',
            'from_node_id' => $appellate->node_id,
            'to_node_id' => $rtsComm->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_4',
            'from_node_id' => $rtsComm->node_id,
            'to_node_id' => $investigate->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_5',
            'from_node_id' => $investigate->node_id,
            'to_node_id' => $validJust->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_6',
            'from_node_id' => $investigate->node_id,
            'to_node_id' => $invalidJust->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_7',
            'from_node_id' => $validJust->node_id,
            'to_node_id' => $validS12->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_8',
            'from_node_id' => $validS12->node_id,
            'to_node_id' => $servicePenalty->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_9',
            'from_node_id' => $invalidJust->node_id,
            'to_node_id' => $invalidS12->node_id,
        ]);
        
        Connection::create([
            'flow_id' => $defaultFlow->id,
            'connection_id' => 'conn_10',
            'from_node_id' => $invalidS12->node_id,
            'to_node_id' => $reject->node_id,
        ]);
        
        $this->command->info('✅ Default flowchart seeded successfully!');
    }
}
