<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dynamic Flowchart System - Laravel + Bootstrap</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            user-select: none;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(255,255,255,0.95);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .main-container {
            height: calc(100vh - 70px);
            margin-top: 70px;
            padding: 20px;
        }
        
        .sidebar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            height: 100%;
            overflow-y: auto;
            padding: 20px;
        }
        
        .component-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 12px;
            cursor: grab;
            transition: all 0.3s;
            text-align: center;
        }
        
        .component-card:hover {
            background: #e7f3ff;
            border-color: #0d6efd;
            transform: translateX(5px);
        }
        
        .component-card:active {
            cursor: grabbing;
        }
        
        .canvas-wrapper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .canvas-toolbar {
            background: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            border-radius: 15px 15px 0 0;
        }
        
        .flow-canvas {
            position: relative;
            width: 100%;
            height: calc(100% - 60px);
            background: 
                linear-gradient(90deg, #f0f0f0 1px, transparent 1px),
                linear-gradient(0deg, #f0f0f0 1px, transparent 1px);
            background-size: 30px 30px;
            overflow: auto;
            cursor: crosshair;
        }
        
        .canvas-container {
            position: relative;
            min-width: 3000px;
            min-height: 2000px;
            transform-origin: 0 0;
            transition: transform 0.1s ease;
        }
        
        .flow-node {
            position: absolute;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            cursor: grab;
            transition: box-shadow 0.2s;
            min-width: 160px;
            z-index: 10;
        }
        
        .flow-node:active {
            cursor: grabbing;
        }
        
        .flow-node.selected {
            box-shadow: 0 0 0 3px #0d6efd, 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .node-header {
            padding: 12px 15px 8px 15px;
            font-weight: 600;
            font-size: 13px;
            border-bottom: 2px solid;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .node-body {
            padding: 10px 15px;
            font-size: 12px;
            color: #6c757d;
        }
        
        .delete-node-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #dc3545;
            padding: 0 5px;
            font-size: 14px;
        }
        
        .connection-handle {
            position: absolute;
            bottom: -10px;
            right: -10px;
            width: 30px;
            height: 30px;
            background: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: crosshair;
            color: white;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 15;
        }
        
        .connection-handle:hover {
            background: #0b5ed7;
            transform: scale(1.1);
        }
        
        svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 5;
        }
        
        svg line {
            pointer-events: stroke;
            cursor: pointer;
        }
        
        svg line:hover {
            stroke: #ff6b6b !important;
            stroke-width: 3 !important;
        }
        
        .zoom-controls {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 20;
            background: white;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .temp-connection {
            animation: pulse 1s infinite;
        }
        
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: #0d6efd;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-project-diagram"></i> Dynamic Flowchart System
        </a>
        <div class="ms-auto d-flex gap-2">
            <select id="flowSelector" class="form-select form-select-sm" style="width: 250px;">
                <option value="">Loading flows...</option>
            </select>
            <button class="btn btn-sm btn-primary" onclick="showNewFlowModal()">
                <i class="fas fa-plus"></i> New Flow
            </button>
            <button class="btn btn-sm btn-success" onclick="saveCurrentFlow()">
                <i class="fas fa-save"></i> Save
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteCurrentFlow()">
                <i class="fas fa-trash"></i> Delete
            </button>
            <button class="btn btn-sm btn-info" onclick="duplicateFlow()">
                <i class="fas fa-copy"></i> Duplicate
            </button>
            <button class="btn btn-sm btn-secondary" onclick="exportFlow()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-sm btn-warning" onclick="loadSampleFlow()">
                <i class="fas fa-chart-line"></i> Load Sample
            </button>
        </div>
    </div>
</nav>

<div class="main-container">
    <div class="row h-100 g-3">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <h5><i class="fas fa-cubes"></i> Components Library</h5>
                <p class="text-muted small">Drag and drop onto canvas</p>
                <div id="componentsList"></div>
                
                <hr class="my-3">
                
                <h6><i class="fas fa-info-circle"></i> Instructions</h6>
                <ul class="small text-muted">
                    <li><i class="fas fa-mouse-pointer"></i> Drag components from library</li>
                    <li><i class="fas fa-link"></i> Click blue dot to create connections</li>
                    <li><i class="fas fa-arrows-alt"></i> Drag nodes to reposition</li>
                    <li><i class="fas fa-times"></i> Click ✕ to delete node</li>
                    <li><i class="fas fa-trash-alt"></i> Double-click line to remove connection</li>
                    <li><i class="fas fa-save"></i> Click Save to persist in database</li>
                </ul>
                
                <div class="alert alert-info small mt-2">
                    <i class="fas fa-database"></i> Data is saved to MySQL database
                </div>
            </div>
        </div>
        
        <!-- Canvas -->
        <div class="col-md-9">
            <div class="canvas-wrapper">
                <div class="canvas-toolbar d-flex justify-content-between align-items-center">
                    <div>
                        <span id="flowNameDisplay" class="fw-bold">
                            <i class="fas fa-project-diagram"></i> Current Flow: 
                        </span>
                        <span id="currentFlowName" class="text-primary">None</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary" onclick="zoomIn()">
                            <i class="fas fa-search-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="zoomOut()">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="resetZoom()">
                            <i class="fas fa-expand"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="centerCanvas()">
                            <i class="fas fa-crosshairs"></i>
                        </button>
                    </div>
                </div>
                <div class="flow-canvas" id="flowCanvas">
                    <div class="canvas-container" id="canvasContainer">
                        <div class="loading">Drop components here...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Zoom Controls -->
<div class="zoom-controls">
    <span id="zoomLevel" class="badge bg-secondary me-2">100%</span>
</div>

<!-- New Flow Modal -->
<div class="modal fade" id="newFlowModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Create New Flow</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Flow Name</label>
                    <input type="text" id="newFlowName" class="form-control" placeholder="Enter flow name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea id="newFlowDesc" class="form-control" rows="3" placeholder="Flow description (optional)"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createNewFlow()">Create</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Global variables
    let nodes = [];
    let connections = [];
    let currentFlowId = null;
    let zoomLevel = 1;
    let isDragging = false;
    let draggingNodeId = null;
    let dragStart = { x: 0, y: 0 };
    let nodeStartPos = { x: 0, y: 0 };
    let isConnecting = false;
    let connectingFromId = null;
    let tempLine = null;
    let svgOverlay = null;
    
    // Components library
    const components = [
        { type: 'citizen', label: 'Citizen', icon: '🧑', color: '#0d6efd' },
        { type: 'service-point', label: 'Service Point', icon: '🏢', color: '#198754' },
        { type: 'appellate-auth', label: 'Appellate Authority S6(1)', icon: '⚖️', color: '#6f42c1' },
        { type: 'rts-commission', label: 'RTS Commission S6(1) & 24', icon: '📜', color: '#fd7e14' },
        { type: 'investigate', label: 'Investigate S6(2)', icon: '🔍', color: '#d63384' },
        { type: 'valid-justification', label: 'Valid Justification S6(3)', icon: '✅', color: '#20c997' },
        { type: 'invalid-justification', label: 'Invalid Justification S6(3)', icon: '⚠️', color: '#fd7e14' },
        { type: 'valid-justification-s12', label: 'Valid Justification S12', icon: '📋', color: '#0dcaf0' },
        { type: 'invalid-justification-s12', label: 'Invalid Justification S12', icon: '🚫', color: '#dc3545' },
        { type: 'completed', label: 'Completed', icon: '✅', color: '#20c997' },
        { type: 'service-penalty', label: 'Service Provided & Penalty', icon: '💰', color: '#198754' },
        { type: 'reject', label: 'Reject', icon: '❌', color: '#dc3545' }
    ];
    
    // Initialize
    $(document).ready(function() {
        loadComponents();
        loadFlows();
        setupEventListeners();
    });
    
    function loadComponents() {
        const container = $('#componentsList');
        container.empty();
        
        components.forEach(comp => {
            container.append(`
                <div class="component-card" draggable="true" data-type="${comp.type}" data-label="${comp.label}">
                    <div style="font-size: 24px;">${comp.icon}</div>
                    <div class="mt-1 small fw-bold">${comp.label}</div>
                </div>
            `);
        });
        
        $('.component-card').on('dragstart', handleDragStart);
    }
    
    function handleDragStart(e) {
        const card = $(e.target).closest('.component-card');
        e.originalEvent.dataTransfer.setData('text/plain', JSON.stringify({
            type: card.data('type'),
            label: card.data('label')
        }));
    }
    
    async function loadFlows() {
        try {
            const response = await fetch('/flows');
            const flows = await response.json();
            const selector = $('#flowSelector');
            selector.empty();
            
            if (flows.length === 0) {
                selector.append('<option value="">No flows found. Create one!</option>');
                // Create a default flow if none exists
                await createDefaultFlow();
                return;
            }
            
            flows.forEach(flow => {
                selector.append(`<option value="${flow.id}">${flow.name} (${new Date(flow.created_at).toLocaleDateString()})</option>`);
            });
            
            if (flows.length > 0) {
                await loadFlow(flows[0].id);
            }
        } catch (error) {
            console.error('Error loading flows:', error);
        }
    }
    
    async function createDefaultFlow() {
        try {
            const response = await fetch('/flows', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({ 
                    name: 'Default Flow', 
                    description: 'Default flowchart created automatically' 
                })
            });
            const result = await response.json();
            if (result.success) {
                await loadFlows();
            }
        } catch (error) {
            console.error('Error creating default flow:', error);
        }
    }
    
    async function loadFlow(flowId) {
        try {
            $('.loading').show();
            const response = await fetch(`/flow/${flowId}`);
            const data = await response.json();
            
            currentFlowId = flowId;
            
            // Map the data correctly - handle both field naming conventions
            nodes = (data.nodes || []).map(node => ({
                id: node.id || node.node_id,
                type: node.type || node.node_type,
                label: node.label,
                x: parseFloat(node.x || node.position_x || 0),
                y: parseFloat(node.y || node.position_y || 0),
                width: node.width || 180,
                height: node.height || 78
            }));
            
            connections = (data.connections || []).map(conn => ({
                id: conn.id || conn.connection_id,
                from: conn.from || conn.from_node_id || conn.fromNodeId,
                to: conn.to || conn.to_node_id || conn.toNodeId
            }));
            
            $('#currentFlowName').text(data.flow?.name || 'Unknown Flow');
            $('.loading').hide();
            renderCanvas();
            
            console.log('Loaded nodes:', nodes.length);
            console.log('Loaded connections:', connections.length);
        } catch (error) {
            console.error('Error loading flow:', error);
            $('.loading').hide();
            // Initialize with empty canvas
            nodes = [];
            connections = [];
            renderCanvas();
        }
    }
    
    function renderCanvas() {
        const container = $('#canvasContainer');
        container.empty();
        container.css('transform', `scale(${zoomLevel})`);
        
        if (nodes.length === 0) {
            container.html('<div class="loading">Drop components here to build your flowchart...</div>');
            return;
        }
        
        // Render nodes
        nodes.forEach(node => {
            const nodeEl = $(`
                <div class="flow-node" data-id="${node.id}" style="left: ${node.x}px; top: ${node.y}px; width: ${node.width}px;">
                    <div class="node-header" style="border-bottom-color: ${getNodeColor(node.type)}">
                        <span><i class="fas fa-${getNodeIcon(node.type)}"></i> ${node.label}</span>
                        <button class="delete-node-btn" onclick="event.stopPropagation(); deleteNode('${node.id}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="node-body">
                        <small>${node.type === 'citizen' ? 'Initial Request' : 'Process Step'}</small>
                    </div>
                    <div class="connection-handle" data-id="${node.id}">
                        <i class="fas fa-link"></i>
                    </div>
                </div>
            `);
            
            nodeEl.on('mousedown', (e) => {
                if ($(e.target).closest('.delete-node-btn').length) return;
                if ($(e.target).closest('.connection-handle').length) {
                    startConnection(node.id, e);
                    return;
                }
                startDrag(node.id, e);
            });
            
            container.append(nodeEl);
        });
        
        // Create SVG overlay
        if (svgOverlay) svgOverlay.remove();
        svgOverlay = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgOverlay.style.position = 'absolute';
        svgOverlay.style.top = '0';
        svgOverlay.style.left = '0';
        svgOverlay.style.width = '100%';
        svgOverlay.style.height = '100%';
        svgOverlay.style.pointerEvents = 'none';
        container[0].appendChild(svgOverlay);
        
        // Draw connections
        connections.forEach(conn => {
            const fromNode = nodes.find(n => n.id === conn.from);
            const toNode = nodes.find(n => n.id === conn.to);
            
            if (fromNode && toNode) {
                const fromX = fromNode.x + fromNode.width - 8;
                const fromY = fromNode.y + fromNode.height / 2;
                const toX = toNode.x + 8;
                const toY = toNode.y + toNode.height / 2;
                
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', fromX);
                line.setAttribute('y1', fromY);
                line.setAttribute('x2', toX);
                line.setAttribute('y2', toY);
                line.setAttribute('stroke', '#6c757d');
                line.setAttribute('stroke-width', '2.5');
                line.setAttribute('stroke-linecap', 'round');
                line.style.pointerEvents = 'stroke';
                line.style.cursor = 'pointer';
                line.setAttribute('data-conn-id', conn.id);
                line.addEventListener('dblclick', () => deleteConnection(conn.id));
                svgOverlay.appendChild(line);
                
                // Arrow marker
                const angle = Math.atan2(toY - fromY, toX - fromX);
                const arrowX = toX - 12 * Math.cos(angle);
                const arrowY = toY - 12 * Math.sin(angle);
                const arrow = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
                arrow.setAttribute('points', `${arrowX},${arrowY} ${arrowX - 8},${arrowY - 4} ${arrowX - 8},${arrowY + 4}`);
                arrow.setAttribute('fill', '#6c757d');
                svgOverlay.appendChild(arrow);
            }
        });
        
        $('#zoomLevel').text(Math.round(zoomLevel * 100) + '%');
    }
    
    function getNodeColor(type) {
        const colors = {
            'citizen': '#0d6efd', 'service-point': '#198754', 'appellate-auth': '#6f42c1',
            'rts-commission': '#fd7e14', 'investigate': '#d63384', 'valid-justification': '#20c997',
            'invalid-justification': '#fd7e14', 'valid-justification-s12': '#0dcaf0',
            'invalid-justification-s12': '#dc3545', 'service-penalty': '#198754', 'reject': '#dc3545'
        };
        return colors[type] || '#6c757d';
    }
    
    function getNodeIcon(type) {
        const icons = {
            'citizen': 'user', 'service-point': 'building', 'appellate-auth': 'gavel',
            'rts-commission': 'file-alt', 'investigate': 'search', 'valid-justification': 'check-circle',
            'invalid-justification': 'exclamation-triangle', 'valid-justification-s12': 'check-double',
            'invalid-justification-s12': 'ban', 'service-penalty': 'money-bill', 'reject': 'times-circle'
        };
        return icons[type] || 'circle';
    }
    
    function addNode(type, label, x, y) {
        const newNode = {
            id: 'node_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
            type: type,
            label: label,
            x: x - 90,
            y: y - 40,
            width: 180,
            height: 78
        };
        nodes.push(newNode);
        renderCanvas();
    }
    
    function deleteNode(nodeId) {
        if (confirm('Delete this node and all its connections?')) {
            nodes = nodes.filter(n => n.id !== nodeId);
            connections = connections.filter(c => c.from !== nodeId && c.to !== nodeId);
            renderCanvas();
        }
    }
    
    function addConnection(fromId, toId) {
        if (fromId === toId) {
            alert('Cannot connect a node to itself');
            return false;
        }
        if (connections.some(c => c.from === fromId && c.to === toId)) {
            alert('Connection already exists');
            return false;
        }
        
        connections.push({
            id: 'conn_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
            from: fromId,
            to: toId
        });
        renderCanvas();
        return true;
    }
    
    function deleteConnection(connId) {
        if (confirm('Remove this connection?')) {
            connections = connections.filter(c => c.id !== connId);
            renderCanvas();
        }
    }
    
    function startDrag(nodeId, e) {
        isDragging = true;
        draggingNodeId = nodeId;
        dragStart = { x: e.clientX, y: e.clientY };
        const node = nodes.find(n => n.id === nodeId);
        if (node) {
            nodeStartPos = { x: node.x, y: node.y };
        }
        e.preventDefault();
    }
    
    function startConnection(nodeId, e) {
        isConnecting = true;
        connectingFromId = nodeId;
        
        const fromNode = nodes.find(n => n.id === nodeId);
        if (!fromNode) return;
        
        const startX = fromNode.x + fromNode.width - 8;
        const startY = fromNode.y + fromNode.height / 2;
        
        tempLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        tempLine.setAttribute('stroke', '#ff6b6b');
        tempLine.setAttribute('stroke-width', '3');
        tempLine.setAttribute('stroke-dasharray', '8,4');
        tempLine.setAttribute('x1', startX);
        tempLine.setAttribute('y1', startY);
        tempLine.setAttribute('x2', startX);
        tempLine.setAttribute('y2', startY);
        tempLine.classList.add('temp-connection');
        svgOverlay.appendChild(tempLine);
        
        const updateTemp = (mouseX, mouseY) => {
            const canvasRect = document.getElementById('canvasContainer').getBoundingClientRect();
            const relativeX = (mouseX - canvasRect.left) / zoomLevel;
            const relativeY = (mouseY - canvasRect.top) / zoomLevel;
            tempLine.setAttribute('x2', relativeX);
            tempLine.setAttribute('y2', relativeY);
        };
        
        const onMouseMove = (e) => updateTemp(e.clientX, e.clientY);
        const onMouseUp = (e) => {
            const elements = document.elementsFromPoint(e.clientX, e.clientY);
            let targetId = null;
            
            for (let el of elements) {
                if (el.classList && el.classList.contains('flow-node')) {
                    targetId = el.getAttribute('data-id');
                    break;
                }
            }
            
            if (targetId && targetId !== connectingFromId) {
                addConnection(connectingFromId, targetId);
            }
            
            if (tempLine) tempLine.remove();
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            isConnecting = false;
            connectingFromId = null;
        };
        
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
        e.preventDefault();
        e.stopPropagation();
    }
    
    // Canvas drop
    $('#flowCanvas').on('dragover', (e) => e.preventDefault());
    $('#flowCanvas')[0].addEventListener('drop', (e) => {
        e.preventDefault();
        const rect = $('#canvasContainer')[0].getBoundingClientRect();
        const x = (e.clientX - rect.left) / zoomLevel;
        const y = (e.clientY - rect.top) / zoomLevel;
        const data = JSON.parse(e.dataTransfer.getData('text/plain'));
        addNode(data.type, data.label, x, y);
    });
    
    // Global mouse events
    $(document).on('mousemove', (e) => {
        if (isDragging && draggingNodeId) {
            const dx = (e.clientX - dragStart.x) / zoomLevel;
            const dy = (e.clientY - dragStart.y) / zoomLevel;
            const node = nodes.find(n => n.id === draggingNodeId);
            if (node) {
                node.x = nodeStartPos.x + dx;
                node.y = nodeStartPos.y + dy;
                renderCanvas();
            }
        }
    });
    
    $(document).on('mouseup', () => {
        isDragging = false;
        draggingNodeId = null;
    });
    
    function setupEventListeners() {
        $('#flowSelector').on('change', async (e) => {
            if (e.target.value) {
                await loadFlow(e.target.value);
            }
        });
    }
    
    async function saveCurrentFlow() {
        if (!currentFlowId) {
            alert('No flow selected. Create a new flow first.');
            return;
        }
        
        const saveData = {
            nodes: nodes.map(node => ({
                id: node.id,
                type: node.type,
                label: node.label,
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height
            })),
            connections: connections.map(conn => ({
                id: conn.id,
                from: conn.from,
                to: conn.to
            }))
        };
        
        try {
            const response = await fetch(`/flows/${currentFlowId}/save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(saveData)
            });
            
            const result = await response.json();
            if (result.success) {
                alert(`✅ Flow saved successfully! (${nodes.length} nodes, ${connections.length} connections)`);
            } else {
                alert('❌ Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error saving flow:', error);
            alert('❌ Error saving flow: ' + error.message);
        }
    }
    
    async function createNewFlow() {
        const name = $('#newFlowName').val();
        const description = $('#newFlowDesc').val();
        
        if (!name) {
            alert('Please enter a flow name');
            return;
        }
        
        try {
            const response = await fetch('/flows', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({ name, description })
            });
            
            const result = await response.json();
            if (result.success) {
                bootstrap.Modal.getInstance(document.getElementById('newFlowModal')).hide();
                await loadFlows();
                await loadFlow(result.flow.id);
                $('#newFlowName').val('');
                $('#newFlowDesc').val('');
            }
        } catch (error) {
            alert('Error creating flow: ' + error.message);
        }
    }
    
    async function deleteCurrentFlow() {
        if (!currentFlowId) return;
        if (!confirm('Delete this flow permanently? This cannot be undone.')) return;
        
        try {
            await fetch(`/flows/${currentFlowId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            await loadFlows();
            nodes = [];
            connections = [];
            renderCanvas();
            alert('Flow deleted successfully');
        } catch (error) {
            alert('Error deleting flow: ' + error.message);
        }
    }
    
    async function duplicateFlow() {
        if (!currentFlowId) return;
        
        try {
            const response = await fetch(`/flows/${currentFlowId}/duplicate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const result = await response.json();
            if (result.success) {
                await loadFlows();
                await loadFlow(result.flow.id);
                alert('Flow duplicated successfully');
            }
        } catch (error) {
            alert('Error duplicating flow: ' + error.message);
        }
    }
    
    function exportFlow() {
        if (!currentFlowId) return;
        window.location.href = `/flows/${currentFlowId}/export`;
    }
    
    function loadSampleFlow() {
        // Create a sample flowchart
        nodes = [];
        connections = [];
        
        // Add sample nodes
        const citizen = { id: 'sample_citizen', type: 'citizen', label: 'Citizen Submits Complaint', x: 400, y: 50, width: 200, height: 70 };
        const servicePoint = { id: 'sample_service', type: 'service-point', label: 'Service Point Officer', x: 400, y: 160, width: 200, height: 70 };
        const decision = { id: 'sample_decision', type: 'decision', label: 'Decision', x: 400, y: 270, width: 180, height: 70 };
        const completed = { id: 'sample_completed', type: 'completed', label: '✅ Completed', x: 150, y: 350, width: 160, height: 60 };
        const delayed = { id: 'sample_delayed', type: 'delayed', label: '⚠️ Delayed/Rejected', x: 650, y: 350, width: 180, height: 60 };
        const appellate = { id: 'sample_appellate', type: 'appellate-auth', label: 'Appellate Authority', x: 650, y: 460, width: 200, height: 70 };
        
        nodes.push(citizen, servicePoint, decision, completed, delayed, appellate);
        
        // Add sample connections
        connections.push(
            { id: 'conn1', from: citizen.id, to: servicePoint.id },
            { id: 'conn2', from: servicePoint.id, to: decision.id },
            { id: 'conn3', from: decision.id, to: completed.id },
            { id: 'conn4', from: decision.id, to: delayed.id },
            { id: 'conn5', from: delayed.id, to: appellate.id }
        );
        
        renderCanvas();
        alert('Sample flow loaded! You can edit and save it.');
    }
    
    function zoomIn() {
        zoomLevel = Math.min(zoomLevel + 0.1, 2);
        renderCanvas();
    }
    
    function zoomOut() {
        zoomLevel = Math.max(zoomLevel - 0.1, 0.5);
        renderCanvas();
    }
    
    function resetZoom() {
        zoomLevel = 1;
        renderCanvas();
    }
    
    function centerCanvas() {
        const container = $('#canvasContainer');
        const wrapper = $('.flow-canvas');
        if (nodes.length > 0) {
            const avgX = nodes.reduce((sum, n) => sum + n.x, 0) / nodes.length;
            const avgY = nodes.reduce((sum, n) => sum + n.y, 0) / nodes.length;
            wrapper.scrollLeft(avgX - wrapper.width() / 2);
            wrapper.scrollTop(avgY - wrapper.height() / 2);
        }
    }
    
    function showNewFlowModal() {
        const modal = new bootstrap.Modal(document.getElementById('newFlowModal'));
        modal.show();
    }
</script>
</body>
</html>