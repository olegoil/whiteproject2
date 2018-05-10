function pnotealert(val) {
    new PNotify({
        title: "Error",
        type: "error",
        text: "No such "+val+"!",
        nonblock: {
            nonblock: true
        },
        before_close: function(PNotify) {
            PNotify.update({
                    title: PNotify.options.title + " - Enjoy your Stay",
                    before_close: null
            });
            PNotify.queueRemove();
            return false;
        }
    });
}

function ajaxSend(val1, val2) {
    var datastr = 'act=docproof&adr='+val1+'&amnt='+val2;
    $.ajax({
        type: 'post',
        url: '/coms/mktransaction.php',
        data: datastr,
        success: function(suc) {
            // console.log(JSON.stringify(suc));
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
                $('#usersTable').DataTable().ajax.reload();
            }
        },
        error: function(err) {
            alert('Some error occured!')
        }
    })
}

function antoconfirm(val1, val2) {
    if(confirm("Approve this document - "+val1)) {
        ajaxSend(val1, val2);
    }
}

function antodeny(val1, val2) {
    if(confirm("Deny this document - "+val1)) {
        ajaxSend(val1, val2);
    }
}