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
          "name" : "bankId", "value" : bankId
        });
        aoData.push({
          "name" : "req", "value" : "transactions"
        });
        aoData.push({
          "name" : "utype", "value" : utype
        });
        aoData.push({
          "name" : "userid", "value" : uid
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
          title: 'ID', 
          "mData": 0,
          "mRender": function(data, type, full) {
            // var id = full[0];
            // if(full[11]) {
            //   id = 'Wire: '+full[11];
            // }
            // return id;
            return full[13];
          }
        },
        {
          title: 'Sent', 
          "mData": 1,
          "mRender": function(data, type, full) {
            return full[2];
          }
        },
        {
          title: 'Received', 
          "mData": 2,
          "mRender": function(data, type, full) {
            return full[3];
          }
        },
        {
          title: 'Date',
          "mData": 3,
          "mRender": function(data, type, full) {
            return full[8];
          }
        },
        { 
          title: 'Options', 
          "mData": 4,
          "mRender": function(data, type, full) {

            var handleBtn = '&nbsp;';
            if(full[9] == 7 && (full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR')) {
                handleBtn = '<span class="text-success" style="height:25px;">Aprofed Exchange</span>';
            }
            else if((full[9] == 3 && (full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR')) || (full[9] == 6 && (full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR'))) {
                handleBtn = '<span class="text-danger" style="height:25px;">Denied Exchange</span>';
            }
            else if(full[5] == 'Request WCR' || full[5] == 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR') {
              handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\'); return false;">Details</button><button class="btn btn-danger btn-xs" style="height:25px;" onclick="transdel(\''+full[0]+'\', \'0\'); return false;">Abort</button><span class="text-warning" style="height:25px;">Pending Exchange</span>';
            }
            else if(full[5] != 'Request WCR' || full[5] != 'Sell WCR' || full[5] == 'WCR to WCUR' || full[5] == 'Request BTC to WCR') {
              var transtype = '<span class="text-success" style="height:25px;">Received transaction</span>';
              if(full[1] == uid) {
                transtype = '<span class="text-success" style="height:25px;">Sent transaction</span>';
              }
              handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\'); return false;">Details</button>'+transtype;
            }
                        return handleBtn;

          }
        }
      ]
    });

  });