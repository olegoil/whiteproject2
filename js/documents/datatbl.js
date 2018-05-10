$(function() {

    var transtbl = $('#transTable').DataTable({
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
            "name" : "req", "value" : "documents"
        });
        aoData.push({
            "name" : "utype", "value" : utype
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
            title: 'Upload',
            "mData": 0,
            "mRender": function(data, type, full) {
            return '<a href="../profile/?usr='+full[6]+'">'+full[0]+'</a>';
            }
        },
        {
            title: 'Type', 
            "mData": 1,
            "mRender": function(data, type, full) {
            return full[1];
            }
        },
        {
            title: 'User', 
            "mData": 2,
            "mRender": function(data, type, full) {
            return '<a href="javascript:;" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[6]+'\', \''+full[8]+'\', \''+full[9]+'\'); return false;">'+full[8]+' '+full[9]+'</a>';
            }
        },
        {
            title: 'Uploaded', 
            "mData": 3,
            "mRender": function(data, type, full) {
            return full[2];
            }
        },
        {
            title: 'Options', 
            "mData": 4,
            "mRender": function(data, type, full) {
                var handleBtn = '&nbsp;';
                if(full[4] == 1) {
                    handleBtn = '<div class="btn-group"><a href="/uploads/'+full[7]+'" target="_blank" class="btn btn-primary btn-xs">view</a></div> <b class="text-success">Approved</b>';
                }
                else if(full[4] == 2) {
                    handleBtn = '<div class="btn-group"><a href="/uploads/'+full[7]+'" target="_blank" class="btn btn-primary btn-xs">view</a></div> <b class="text-danger">failed</b>';
                }
                else if(full[4] != '') {
                    handleBtn = '<div class="btn-group"><a href="/uploads/'+full[7]+'" target="_blank" class="btn btn-primary btn-xs">view</a><a href="javascript:;" class="btn btn-success btn-xs" onclick="antoconfirm(\''+full[0]+'\', 1);">confirm</a><a href="javascript:;" class="btn btn-danger btn-xs" onclick="antodeny(\''+full[0]+'\', 2);">deny</a></div>';
                }
                return handleBtn;
            }
        }
        ]
    });

});