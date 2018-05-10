  function ajaxSend(val1, val2) {
    var datastr = 'act=adminproof&adr='+val1+'&amnt='+val2;
    $.ajax({
      type: 'post',
      url: '/coms/mktransaction.php',
      data: datastr,
      success: function(suc) {
        // console.log(JSON.stringify(suc));
        $('#transTable').DataTable().ajax.reload();
      },
      error: function(err) {
        alert('Some error occured!')
      }
    })
  }

  function transallow(val1, val2) {
    if(confirm("Allow this transaction "+val1)) {
        ajaxSend(val1, val2);
    }
  }

  function transdeny(val1, val2) {
    if(confirm("Deny this transaction "+val1)) {
        ajaxSend(val1, val2);
    }
  }

  function transallow2(val1, val2, val3, val4, val5) {
    // console.log("TEST "+val1+' | '+val2+' | '+val3);
    // decision - 1 - if accepted, 2 - if denied
    App.isManagerSend(val1, val2, val3, val4, val5);
  }

  function transdeny2(val1, val2, val3, val4, val5) {
    App.isManagerDeny(val1, val2, val3, val4, val5);
  }

  function transallow3(val1, val3) {
    var val3var = val3.split(' ');
    val3var = val3var[0] / exchangebtc;
    if(confirm("Allow this transaction "+val1)) {
        ajaxSend(val1, val3var);
    }
  }

  function showdetails(val1, val2, val3, val4, val5, val6, val7, val8, val9, val10, val11, val12, val13) {
      var val4var = val4;
      var val5var = val5;
      $('#myModalLabel').html('Details of MintId: <b>'+val1+'</b>');
      var detailsbody = '<table><tr><td><strong>Mint ID</strong></td><td>'+val1+'</td></tr>';
      var mintreq = '';
      if(val12 != 'null') {
        detailsbody += '<tr><td><strong>Wire ID</strong></td><td>'+val12+'</td></tr><tr><td><strong>Wire Type</strong></td><td>'+val11+'</td></tr>';
      }
      if(val13 != 'null') {
        mintreq = '<tr><td><strong>MintRequest ID</strong></td><td>'+val13+'</td></tr>';
      }
      if(val6 == 'Request BTC to WCR') {
        val4var = val4.split(' ');
        val4var = val4var[0] / exchangebtc;
        val4var = val4var + ' WCR';
        val5var = val5 + ' %';
      }
      detailsbody += '<tr><td><strong>User ID</strong></td><td>'+val2+'</td></tr>'+mintreq+'<tr><td><strong>Amount from</strong></td><td>'+val3+'</td></tr><tr><td><strong>Amount to</strong></td><td>'+val4var+'</td></tr><tr><td><strong>Comissions</strong></td><td>'+val5var+'</td></tr><tr><td><strong>Notes</strong></td><td>'+val6+'</td></tr><tr><td><strong>Wallet From</strong></td><td>'+val7+'</td></tr><tr><td><strong>Wallet To</strong></td><td>'+val8+'</td></tr><tr><td><strong>Date</strong></td><td>'+val9+'</td></tr><tr><td><strong>Acception</strong></td><td>Pending</td></tr></table>';
      $('#detailsbody').html(detailsbody);
      $('#myModal').modal('show');
  }