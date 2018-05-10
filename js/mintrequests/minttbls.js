$(function() {

    jQuery.ajax({
      dataType: 'json',
      type: 'get',
      url: 'https://api.coinmarketcap.com/v2/ticker/?limit=10',
      data: 1,
      success: function(res) {
        $.each(res.data, function(index, val) {
          if(val.name == 'Bitcoin') {
            bitcoincost = val.quotes.USD.price;
            // $('.bitcoin').html(val.quotes.USD.price);
            exchangebtc = exchangebtc/bitcoincost;
          }
          else if (val.name == 'Ethereum') {
            ethercost = val.quotes.USD.price;
            // $('.ether').html(val.quotes.USD.price);
            exchangeeth = exchangeeth/ethercost;
          }
          // console.log(val);
        });
      },
      error: function(err) {
        console.log('ERR '+JSON.stringify(err))
      }
    });

    setTimeout(function() {
      App.getEtherBalance();
      App.getBalance();
    }, 2000);

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
          title: 'MintId',
          "mData": 0,
          "mRender": function(data, type, full) {
            var id = '<a href="/profile/?usr='+full[1]+'" >'+full[0]+'</a>';
            if(full[11]) {
              id = 'Wire: '+'<a href="/profile/?usr='+full[1]+'" >'+full[11]+'</a>';
            }
            return id;
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
          title: 'Commissions', 
          "mData": 3,
          "mRender": function(data, type, full) {
            if(full[5] == 'Request BTC to WCR') {
              return full[4] + ' %';
            }
            else {
              return full[4];
            }
          }
        },
        { 
          title: 'Notes', 
          "mData": 4,
          "mRender": function(data, type, full) {
            return full[5];
          }
        },
        { 
          title: 'Date', 
          "mData": 5,
          "mRender": function(data, type, full) {
            return full[8];
          }
        },
        { 
          title: 'Options', 
          "mData": 6,
          "mRender": function(data, type, full) {
            var handleBtn = '&nbsp;';
            if(full[9] == 4) {
                var clickaction = 'onclick="transallow(\''+full[0]+'\', \''+full[2]+'\'); return false;"';
                var clickaction2 = 'onclick="transdeny(\''+full[0]+'\', \'0\'); return false;"';
                if(full[5] == 'WCR to WCUR') {
                  clickaction = 'onclick="transallow2(\''+full[0]+'\', \''+full[2]+'\', \''+full[7]+'\', \''+full[3]+'\', \''+full[12]+'\'); return false;"';
                  clickaction2 = 'onclick="transdeny2(\''+full[0]+'\', \'0\', \''+full[12]+'\'); return false;"';
                }
                if(full[5] == 'Request BTC to WCR') {
                  clickaction = 'onclick="transallow3(\''+full[0]+'\', \''+full[3]+'\'); return false;"';
                }
                handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\', \''+full[12]+'\'); return false;">Details</button><button class="btn btn-success btn-xs" style="height:25px;" '+clickaction+'>Allow</button><button class="btn btn-danger btn-xs" style="height:25px;" '+clickaction2+'>Deny</button>';
            }
            else if(full[9] == 7) {
                handleBtn = '<button class="btn btn-success btn-xs" style="height:25px;">Aprofed</button>';
            }
            else if(full[9] == 6) {
                handleBtn = '<button class="btn btn-danger btn-xs" style="height:25px;">Denied</button>';
            }
            return handleBtn;
          }
        }
      ]
    });

});