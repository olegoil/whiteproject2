  function transdel(val1, val2) {
    if(confirm("Delete this transaction "+val1)) {
        ajaxSend(val1, val2);
    }
  }

  function showdetails(val1, val2, val3, val4, val5, val6, val7, val8, val9, val10, val11, val12) {
    var handleBtn = '&nbsp;';
    if(val10 == 7 && (val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR')) {
      handleBtn = '<span class="text-success" style="height:25px;">Aprofed</span>';
    }
    else if((val10 == 3 && (val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR')) || (val10 == 6 && (val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR'))) {
      handleBtn = '<span class="text-danger" style="height:25px;">Denied</span>';
    }
    else if(val6 == 'Request WCR' || val6 == 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR') {
      handleBtn = '<span class="text-warning" style="height:25px;">Pending</span>';
    }
    else if(val6 != 'Request WCR' || val6 != 'Sell WCR' || val6 == 'WCR to WCUR' || val6 == 'Request BTC to WCR') {
      handleBtn = '<span class="text-success" style="height:25px;">Received transaction</span>';
      if(val2 == uid) {
        handleBtn = '<span class="text-success" style="height:25px;">Sent transaction</span>';
      }
    }
    $('#myModalLabel').html('Details of Transfer: <b>'+val1+'</b>');
    var detailsbody = '<table><tr><td><strong>ID</strong></td><td>'+val1+'</td></tr>';
    if(val12 != 'null') {
      detailsbody += '<tr><td><strong>Wire ID</strong></td><td>'+val12+'</td></tr><tr><td><strong>Wire Type</strong></td><td>'+val11+'</td></tr>';
    }
    detailsbody += '<tr><td><strong>Amount from</strong></td><td>'+val3+'</td></tr><tr><td><strong>Amount to</strong></td><td>'+val4+'</td></tr><tr><td><strong>Comissions</strong></td><td>'+val5+'</td></tr><tr><td><strong>Notes</strong></td><td>'+val6+'</td></tr><tr><td><strong>Wallet From</strong></td><td>'+val7+'</td></tr><tr><td><strong>Wallet To</strong></td><td>'+val8+'</td></tr><tr><td><strong>Date</strong></td><td>'+val9+'</td></tr><tr><td><strong>Acception</strong></td><td>'+handleBtn+'</td></tr></table>';
    $('#detailsbody').html(detailsbody);
    $('#myModal').modal('show');
  }

  function ajaxSend(val1, val2) {
    var datastr = 'act=userproof&adr='+val1+'&amnt='+val2;
    $.ajax({
      type: 'post',
      url: '/coms/mktransaction.php',
      data: datastr,
      success: function(suc) {
          console.log(JSON.stringify(suc));
          $('#transTable').DataTable().ajax.reload();
      },
      error: function(err) {
          alert('Some error occured!')
      }
    })
  }