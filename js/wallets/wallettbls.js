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

    // setTimeout(function() {
    //     App.getBalance();
    //     App.getTotalSupply();
    // }, 2000);

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
                "name" : "bankId", "value" : recid
            });
            aoData.push({
                "name" : "req", "value" : "transactions"
            });
            aoData.push({
                "name" : "utype", "value" : <?php echo '"'.$sql->checkLevel().'"'; ?>
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
                    var ending = '<button class="btn btn-danger btn-xs" style="height:25px;" onclick="transdeny(\''+full[0]+'\', \'0\'); return false;">Deny</button>';
                    if(full[9] == 0) {
                        var btns = 'onclick="transallow(\''+full[0]+'\', \''+full[2]+'\');';
                        if(full[5] == 'WCR to WCUR' && (full[12] == 'null' || full[12] == null || full[12] == '' || full[12] == 0)) {
                            btns = 'onclick="transallow2(\''+full[0]+'\', \''+full[2]+'\', \''+full[7]+'\');';
                        }
                        else if(full[5] == 'WCR to WCUR' && full[12] != 'null' && full[12] != null && full[12] != '') {
                            btns = 'onclick="sendTokens(\''+full[0]+'\', \''+full[3]+'\', \''+full[7]+'\', \''+full[12]+'\');';
                            ending = '';
                        }
                        handleBtn = '<button class="btn btn-default btn-xs" style="height:25px;" onclick="showdetails(\''+full[0]+'\', \''+full[1]+'\', \''+full[2]+'\', \''+full[3]+'\', \''+full[4]+'\', \''+full[5]+'\', \''+full[6]+'\', \''+full[7]+'\', \''+full[8]+'\', \''+full[9]+'\', \''+full[10]+'\', \''+full[11]+'\', \''+full[12]+'\'); return false;">Details</button><button class="btn btn-success btn-xs" style="height:25px;" '+btns+' return false;">Allow</button>'+ending;
                    }
                    else if(full[9] == 1) {
                        handleBtn = '<button class="btn btn-success btn-xs" style="height:25px;">Aprofed</button>';
                    }
                    else if(full[9] == 2) {
                        handleBtn = '<button class="btn btn-danger btn-xs" style="height:25px;">Denied</button>';
                    }
                    return handleBtn;
                }
            }
        ]
    });

    var wallettbl = $('#walletTable').DataTable({
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
                "name" : "req", "value" : "wallets"
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
            { title: 'WalletId', "mData": 0 },
            {
                title: 'UserId',
                "mData": 1,
                "mRender": function(data, type, full) {
                    return '<a href="/profile/?usr='+full[1]+'" >'+full[1]+'</a>';
                }
            },
            {
                title: 'Type', 
                "mData": 2,
                "mRender": function(data, type, full) {
                    return full[2];
                }
            },
            {
                title: 'Amount', 
                "mData": 3,
                "mRender": function(data, type, full) {
                    return full[3];
                }
            },
            {
                title: 'Date', 
                "mData": 4,
                "mRender": function(data, type, full) {
                    return full[4];
                }
            }
        ]
    });

});