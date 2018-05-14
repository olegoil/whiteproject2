$(function() {

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
                "name" : "req", "value" : "users"
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
                    return '<a href="../profile/?usr='+full[0]+'">'+full[0]+'</a>';
                }
            },
            {
                title: 'Fullname',
                "mData": 1,
                "mRender": function(data, type, full) {
                    return full[6] + ' ' + full[7];
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
                    var usrtype = 'USER';
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
                title: 'Address/Phone', 
                "mData": 6,
                "mRender": function(data, type, full) {
                    return full[12] + ' ' + full[13];
                }
            },
            { 
                title: 'Status', 
                "mData": 7,
                "mRender": function(data, type, full) {
                    var userconf = '<b class="text-danger">email not confirmed</b>';
                    if(full[15]) {
                        if(full[15] == 1) {
                            userconf = '<b class="text-success">email confirmed</b>';
                        }
                    }
                    var mobileconf = '<b class="text-danger">mobile not confirmed</b>';
                    if(full[16]) {
                        if(full[16] == 1) {
                            mobileconf = '<b class="text-success">mobile confirmed</b>';
                        }
                    }
                    var addressconf = '<b class="text-danger">address not confirmed</b>';
                    if(full[17]) {
                        if(full[17] == 1) {
                            addressconf = '<b class="text-success">address confirmed</b>';
                        }
                    }
                    var passportconf = '<b class="text-danger">passport not confirmed</b>';
                    if(full[18]) {
                        if(full[18] == 1) {
                            passportconf = '<b class="text-success">passport confirmed</b>';
                        }
                    }
                    return userconf + ' / ' + mobileconf + ' / ' + addressconf + ' / ' + passportconf;
                }
            }
        ]
    });

});