<?php

// database/seeders/ProcessFlowSeeder.php

namespace Database\Seeders;

use App\Models\Flow;
use App\Models\Node;
use App\Models\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProcessFlowSeeder extends Seeder
{
    public function run(): void
    {
        // Create the main flow
        $flow = Flow::create([
            'name' => 'Citizen Complaint Process Flow',
            'description' => 'Complete complaint submission and appeals process workflow',
            'color_theme' => 'default',
        ]);

        // ==========================================
        // LEVEL 1: INITIAL COMPLAINT SUBMISSION
        // ==========================================
        
        $citizenComplaint = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_citizen_complaint',
            'node_type' => 'citizen',
            'label' => 'Citizen Submits Complaint',
            'position_x' => 400,
            'position_y' => 50,
            'width' => 200,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Citizen files initial complaint',
                'icon' => 'fa-user',
                'color' => '#0d6efd'
            ]),
        ]);

        $servicePointOfficer = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_service_point_officer',
            'node_type' => 'service-point',
            'label' => 'Service Point Officer',
            'position_x' => 400,
            'position_y' => 160,
            'width' => 200,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Officer receives and reviews complaint',
                'icon' => 'fa-user-tie',
                'color' => '#198754'
            ]),
        ]);

        // ==========================================
        // LEVEL 2: INITIAL DECISION
        // ==========================================
        
        $initialDecision = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_initial_decision',
            'node_type' => 'decision',
            'label' => 'Decision',
            'position_x' => 400,
            'position_y' => 270,
            'width' => 180,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Initial decision on complaint',
                'icon' => 'fa-gavel',
                'color' => '#6f42c1',
                'is_diamond' => true
            ]),
        ]);

        $completed = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_completed',
            'node_type' => 'completed',
            'label' => '✅ Completed',
            'position_x' => 150,
            'position_y' => 350,
            'width' => 160,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Complaint resolved successfully',
                'icon' => 'fa-check-circle',
                'color' => '#198754',
                'end_node' => true
            ]),
        ]);

        $delayedRejected = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_delayed_rejected',
            'node_type' => 'delayed-rejected',
            'label' => '⚠️ Delayed / Rejected',
            'position_x' => 650,
            'position_y' => 350,
            'width' => 180,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Complaint delayed or rejected',
                'icon' => 'fa-exclamation-triangle',
                'color' => '#fd7e14'
            ]),
        ]);

        // ==========================================
        // LEVEL 3: FIRST APPEAL - APPELLATE AUTHORITY
        // ==========================================
        
        $appellateAuthority = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_appellate_authority',
            'node_type' => 'appellate-auth',
            'label' => 'Appellate Authority',
            'position_x' => 650,
            'position_y' => 460,
            'width' => 200,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'First appeal to Appellate Authority',
                'icon' => 'fa-building',
                'color' => '#6f42c1'
            ]),
        ]);

        $firstAppealDecision = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_first_appeal_decision',
            'node_type' => 'decision',
            'label' => 'Decision',
            'position_x' => 650,
            'position_y' => 570,
            'width' => 180,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Appellate Authority decision',
                'icon' => 'fa-gavel',
                'color' => '#6f42c1',
                'is_diamond' => true
            ]),
        ]);

        $invalidJustification = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_invalid_justification',
            'node_type' => 'invalid-justification',
            'label' => 'Invalid Justification',
            'position_x' => 400,
            'position_y' => 660,
            'width' => 180,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Authority justification is invalid',
                'icon' => 'fa-times-circle',
                'color' => '#dc3545'
            ]),
        ]);

        $validJustification = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_valid_justification',
            'node_type' => 'valid-justification',
            'label' => 'Valid Justification',
            'position_x' => 900,
            'position_y' => 660,
            'width' => 180,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Authority justification is valid',
                'icon' => 'fa-check-circle',
                'color' => '#28a745'
            ]),
        ]);

        // ==========================================
        // LEVEL 4: OUTCOMES OF FIRST APPEAL
        // ==========================================
        
        $serviceWithPenalty = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_service_with_penalty',
            'node_type' => 'service-penalty',
            'label' => '💰 Service Provided + Penalty',
            'position_x' => 400,
            'position_y' => 760,
            'width' => 200,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Service provided and penalty imposed',
                'icon' => 'fa-money-bill-wave',
                'color' => '#ffc107',
                'end_node' => true
            ]),
        ]);

        $rejectFirstAppeal = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_reject_first_appeal',
            'node_type' => 'reject',
            'label' => '❌ Reject',
            'position_x' => 900,
            'position_y' => 760,
            'width' => 160,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'First appeal rejected',
                'icon' => 'fa-ban',
                'color' => '#dc3545'
            ]),
        ]);

        // ==========================================
        // LEVEL 5: SECOND APPEAL - RTS COMMISSION
        // ==========================================
        
        $citizenAppealsAgain = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_citizen_appeals_again',
            'node_type' => 'citizen',
            'label' => 'Citizen Appeals Again',
            'position_x' => 900,
            'position_y' => 860,
            'width' => 200,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Citizen files second appeal',
                'icon' => 'fa-user',
                'color' => '#0d6efd'
            ]),
        ]);

        $rtsCommission = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_rts_commission',
            'node_type' => 'rts-commission',
            'label' => 'RTS Commission',
            'position_x' => 900,
            'position_y' => 970,
            'width' => 220,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Right to Service Commission hearing',
                'icon' => 'fa-landmark',
                'color' => '#fd7e14'
            ]),
        ]);

        $secondAppealDecision = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_second_appeal_decision',
            'node_type' => 'decision',
            'label' => 'Decision',
            'position_x' => 900,
            'position_y' => 1080,
            'width' => 180,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'RTS Commission final decision',
                'icon' => 'fa-gavel',
                'color' => '#6f42c1',
                'is_diamond' => true
            ]),
        ]);

        $invalidJustificationFinal = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_invalid_justification_final',
            'node_type' => 'invalid-justification-s12',
            'label' => 'Invalid Justification',
            'position_x' => 650,
            'position_y' => 1170,
            'width' => 180,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Commission finds justification invalid',
                'icon' => 'fa-times-circle',
                'color' => '#dc3545'
            ]),
        ]);

        $validJustificationFinal = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_valid_justification_final',
            'node_type' => 'valid-justification-s12',
            'label' => 'Valid Justification',
            'position_x' => 1150,
            'position_y' => 1170,
            'width' => 180,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Commission finds justification valid',
                'icon' => 'fa-check-circle',
                'color' => '#28a745'
            ]),
        ]);

        // ==========================================
        // LEVEL 6: FINAL OUTCOMES
        // ==========================================
        
        $serviceWithPenaltyFinal = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_service_penalty_final',
            'node_type' => 'service-penalty',
            'label' => '💰 Service Provided + Penalty',
            'position_x' => 650,
            'position_y' => 1270,
            'width' => 200,
            'height' => 70,
            'metadata' => json_encode([
                'description' => 'Final order: Service with penalty',
                'icon' => 'fa-money-bill-wave',
                'color' => '#ffc107',
                'end_node' => true
            ]),
        ]);

        $rejectFinal = Node::create([
            'flow_id' => $flow->id,
            'node_id' => 'node_reject_final',
            'node_type' => 'reject',
            'label' => '❌ Final Rejection',
            'position_x' => 1150,
            'position_y' => 1270,
            'width' => 180,
            'height' => 60,
            'metadata' => json_encode([
                'description' => 'Final rejection of complaint',
                'icon' => 'fa-ban',
                'color' => '#dc3545',
                'end_node' => true
            ]),
        ]);

        // ==========================================
        // CREATE CONNECTIONS (FLOW PATHS)
        // ==========================================
        
        // Path 1: Initial flow
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_1',
            'from_node_id' => $citizenComplaint->node_id,
            'to_node_id' => $servicePointOfficer->node_id,
            'label' => 'Submit',
            'connection_type' => 'default',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_2',
            'from_node_id' => $servicePointOfficer->node_id,
            'to_node_id' => $initialDecision->node_id,
            'label' => 'Review',
            'connection_type' => 'default',
        ]);

        // Path 2: Initial decision branches
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_3',
            'from_node_id' => $initialDecision->node_id,
            'to_node_id' => $completed->node_id,
            'label' => 'Complaint Resolved',
            'connection_type' => 'success',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_4',
            'from_node_id' => $initialDecision->node_id,
            'to_node_id' => $delayedRejected->node_id,
            'label' => 'Delay / Rejection',
            'connection_type' => 'warning',
        ]);

        // Path 3: First appeal
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_5',
            'from_node_id' => $delayedRejected->node_id,
            'to_node_id' => $appellateAuthority->node_id,
            'label' => 'Appeal',
            'connection_type' => 'default',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_6',
            'from_node_id' => $appellateAuthority->node_id,
            'to_node_id' => $firstAppealDecision->node_id,
            'label' => 'Decision',
            'connection_type' => 'default',
        ]);

        // Path 4: First appeal decision branches
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_7',
            'from_node_id' => $firstAppealDecision->node_id,
            'to_node_id' => $invalidJustification->node_id,
            'label' => 'Invalid Justification → Service + Penalty',
            'connection_type' => 'success',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_8',
            'from_node_id' => $firstAppealDecision->node_id,
            'to_node_id' => $validJustification->node_id,
            'label' => 'Valid Justification → Reject',
            'connection_type' => 'danger',
        ]);

        // Path 5: Outcomes of first appeal
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_9',
            'from_node_id' => $invalidJustification->node_id,
            'to_node_id' => $serviceWithPenalty->node_id,
            'label' => 'Order Issued',
            'connection_type' => 'success',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_10',
            'from_node_id' => $validJustification->node_id,
            'to_node_id' => $rejectFirstAppeal->node_id,
            'label' => 'Appeal Rejected',
            'connection_type' => 'danger',
        ]);

        // Path 6: Second appeal
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_11',
            'from_node_id' => $rejectFirstAppeal->node_id,
            'to_node_id' => $citizenAppealsAgain->node_id,
            'label' => 'Citizen Appeals Again',
            'connection_type' => 'default',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_12',
            'from_node_id' => $citizenAppealsAgain->node_id,
            'to_node_id' => $rtsCommission->node_id,
            'label' => 'Forward to RTS',
            'connection_type' => 'default',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_13',
            'from_node_id' => $rtsCommission->node_id,
            'to_node_id' => $secondAppealDecision->node_id,
            'label' => 'Commission Decision',
            'connection_type' => 'default',
        ]);

        // Path 7: Second appeal decision branches
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_14',
            'from_node_id' => $secondAppealDecision->node_id,
            'to_node_id' => $invalidJustificationFinal->node_id,
            'label' => 'Invalid Justification → Service + Penalty',
            'connection_type' => 'success',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_15',
            'from_node_id' => $secondAppealDecision->node_id,
            'to_node_id' => $validJustificationFinal->node_id,
            'label' => 'Valid Justification → Reject',
            'connection_type' => 'danger',
        ]);

        // Path 8: Final outcomes
        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_16',
            'from_node_id' => $invalidJustificationFinal->node_id,
            'to_node_id' => $serviceWithPenaltyFinal->node_id,
            'label' => 'Final Order',
            'connection_type' => 'success',
        ]);

        Connection::create([
            'flow_id' => $flow->id,
            'connection_id' => 'conn_17',
            'from_node_id' => $validJustificationFinal->node_id,
            'to_node_id' => $rejectFinal->node_id,
            'label' => 'Final Rejection',
            'connection_type' => 'danger',
        ]);

        $this->command->info('✅ Process Flow Seeder Completed Successfully!');
        $this->command->info('📊 Flow Diagram: Citizen Complaint → Appeals → RTS Commission');
        $this->command->info('🔗 Total Nodes: ' . Node::where('flow_id', $flow->id)->count());
        $this->command->info('🔗 Total Connections: ' . Connection::where('flow_id', $flow->id)->count());
    }
}