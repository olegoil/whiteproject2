$(function() {

    setTimeout(function() {
        App.getBalance();
        App.getEtherBalance();
    }, 2000);
    
    var userstbl = $('#usersTable').DataTable({
        // order: [[ 9, "asc" ], [ 0, "desc" ]],
        "displayLength": 15,
        "lengthMenu": [[15, 50, 100, 500, 1000,  -1], [15, 50, 100, 500, 1000, "All"]],
            select: true,
            responsive: true,
            // "bStateSave": true,
            dom: "Bfrtipl",
            buttons: [{
            extend: "copy",
            exportOptions: {
                rows: { filter: 'applied', order: 'current', selected: true }
            },
            className: "btn-sm"
            }, {
            extend: "csv",
            exportOptions: {
                rows: { filter: 'applied', order: 'current', selected: true }
            },
            className: "btn-sm"
            }, {
            extend: "excel",
            exportOptions: {
                rows: { filter: 'applied', order: 'current', selected: true }
            },
            className: "btn-sm"
            }, {
            extend: "pdf",
            exportOptions: {
                rows: { filter: 'applied', order: 'current', selected: true }
            },
            className: "btn-sm"
            }, {
            extend: "print",
            exportOptions: {
                rows: { filter: 'applied', order: 'current', selected: true }
            },
            className: "btn-sm"
            },
            {
                extend: "colvis",
                className: "btn-sm",
                text: "Filter"
            }],
        // "sScrollY": "500px",
        "sAjaxSource": "/coms/getwalletsdata.php",
        "bProcessing": true,
        "bServerSide": true,
        // "sDom": "frtiS",
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            aoData.push({
                "name" : "req", "value" : "kycaml"
            });
            
            $.ajax({
                "dataType": 'json', 
                "type": "POST", 
                "url": sSource, 
                "data": aoData,
                "success": fnCallback,
                "error": function(data) {console.log('ERROR: '+JSON.stringify(data))}
            });
        },
        // "oScroller": {
            // "loadingIndicator": true
        // },
        language: {
            "processing": '<span style="color:#00ff00;"><i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>Loading..</span>'
        },
        columns: [
            {
                title: 'UserId',
                "mData": 0,
                "mRender": function(data, type, full) {
                    var usid = '';
                    if(full[0]) {
                        usid = '<a href="../profile/?usr='+full[0]+'">'+full[0]+'</a>';
                    }
                    return usid;
                }
            },
            {
                title: 'Fullname',
                "mData": 1,
                "mRender": function(data, type, full) {
                    var fulln = '';
                    if(full[0]) {
                        fulln = full[6] + ' ' + full[7];
                    }
                    return fulln;
                }
            },
            {
                title: 'Registration', 
                "mData": 2,
                "mRender": function(data, type, full) {
                    return full[2];
                }
            },
            {
                title: 'Login', 
                "mData": 3,
                "mRender": function(data, type, full) {
                    return full[3];
                }
            },
            { 
                title: 'IP', 
                "mData": 4,
                "mRender": function(data, type, full) {
                    return full[4];
                }
            },
            {
                title: 'Type', 
                "mData": 5,
                "mRender": function(data, type, full) {
                    var usrtype = '';
                    if(full[5] == 0) {
                        usrtype = 'USER';
                    }
                    else if(full[5] == 1) {
                        usrtype = 'MANAGER';
                    }
                    else if(full[5] == 2) {
                        usrtype = 'MINTER';
                    }
                    else if(full[5] == 3) {
                        usrtype = 'KYCAML';
                    }
                    return usrtype;
                }
            },
            {
                title: 'Ethereum address', 
                "mData": 6,
                "mRender": function(data, type, full) {
                    return full[22];
                }
            },
            {
                title: 'Status', 
                "mData": 7,
                "mRender": function(data, type, full) {
                    var btn = '';
                    if(full[0]) {
                        btn = '<button class="btn btn-danger btn-xs" style="height:25px;" onclick="remminter(\''+full[0]+'\', \''+full[22]+'\'); return false;">Remove KYC/AML</button>';
                    }
                    return btn;
                }
            }
        ]
    });

});