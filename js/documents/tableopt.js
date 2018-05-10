function ajaxSend(val1, val2) {
    var datastr = 'act=docproof&adr='+val1+'&amnt='+val2;
    $.ajax({
        type: 'post',
        url: '/coms/mktransaction.php',
        data: datastr,
        success: function(suc) {
          var suc = JSON.parse(suc);
          if(suc.success == 'no doc') {
            pnotealert('document');
          }
          else if(suc.success == 'no handler') {
            pnotealert('handler');
          }
          else if(suc.success == 'no user') {
            pnotealert('user');
          }
          else if(suc.success == 'no doctype') {
            pnotealert('doctype');
          }
          else if(suc.success == '1') {
            $('#transTable').DataTable().ajax.reload();
          }
        },
        error: function(err) {
            alert('Some error occured!')
        }
    })
  }

  function antoconfirm(val1, val2) {
      if(confirm("Approve this Document "+val1)) {
          ajaxSend(val1, val2);
      }
  }

  function antodeny(val1, val2) {
      if(confirm("Deny this document "+val1)) {
          ajaxSend(val1, val2);
      }
  }

  function showdetails(val0, val6, val8, val9) {
    $('#myModalLabel').html('Details of Document: <b>'+val0+'</b>');
    var detailsbody = '<tr><td><strong>User ID</strong></td><td>'+val6+'</td></tr><tr><td><strong>Name</strong></td><td>'+val8+'</td></tr><tr><td><strong>Lastname</strong></td><td>'+val9+'</td></tr><tr><td>Details</td><td><a href="../profile/?usr='+val6+'">Go to Profile</a></td></tr></table>';
    $('#detailsbody').html(detailsbody);
    $('#myModal').modal('show');
  }