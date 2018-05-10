$(function() {

  var d1 = [];
  //var d2 = [];
  
  //here we generate data for chart
  for (var i = firstday; i < today; i+=86400) {
    var toshow = 0;
    var nexti = parseInt(i)+86400;
    var newint = parseInt(i)*1000;
    if(transarr.length > 0) {
      Object.keys(transarr).map(function(objectKey, index) {
        var value = transarr[objectKey];
        if(value.changed) {
          if(value.changed >= parseInt(i) && value.changed < nexti) {
            if(value.userid == uid) {
              newint = parseInt(i) * 1000;
              // console.log(new Date(newint) + ' | ' + new Date(nexti*1000));
              toshow += parseFloat(value.amount_from);
            }
          }
        }
      });
      d1.push([newint, toshow]);
    }
    else {
      var newint = parseInt(i) * 10000;
      d1.push([newint, toshow]);
    }
    // d2.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);
  }
  // console.log(d1.length + ' | ' + JSON.stringify(d1));

  var chartMinDate = d1[0][0]; //first day
  var chartMaxDate = d1[29][0]; //last day

  var tickSize = [1, "day"];
  var tformat = "%m/%d/%y";

  //graph options
  var options = {
    grid: {
      show: true,
      aboveData: true,
      color: "#3f3f3f",
      labelMargin: 10,
      axisMargin: 0,
      borderWidth: 0,
      borderColor: null,
      minBorderMargin: 5,
      clickable: true,
      hoverable: true,
      autoHighlight: true,
      mouseActiveRadius: 100
    },
    series: {
      lines: {
        show: true,
        fill: true,
        lineWidth: 2,
        steps: false
      },
      points: {
        show: true,
        radius: 4.5,
        symbol: "circle",
        lineWidth: 3.0
      }
    },
    legend: {
      position: "ne",
      margin: [0, -25],
      noColumns: 0,
      labelBoxBorderColor: null,
      labelFormatter: function(label, series) {
        // just add some space to labes
        return label + '&nbsp;&nbsp;';
      },
      width: 40,
      height: 1
    },
    colors: chartColours,
    shadowSize: 0,
    tooltip: true, //activate tooltip
    tooltipOpts: {
      content: "%s: %y.0",
      xDateFormat: "%m/%d",
      shifts: {
        x: -30,
        y: -50
      },
      defaultTheme: false
    },
    yaxis: {
      min: 0
    },
    xaxis: {
      mode: "time",
      minTickSize: tickSize,
      timeformat: tformat,
      min: chartMinDate,
      max: chartMaxDate
    }
  };
  var plot = $.plot($("#placeholder33x"), [{
    label: "My transfers",
    data: d1,
    lines: {
      fillColor: "rgba(150, 202, 89, 0.12)"
    }, //#96CA59 rgba(150, 202, 89, 0.42)
    points: {
      fillColor: "#fff"
    }
  }], options);

  $(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
    type: 'bar',
    height: '125',
    barWidth: 13,
    colorMap: {
      '7': '#a1a1a1'
    },
    barSpacing: 2,
    barColor: '#26B99A'
  });

  $(".sparkline11").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
    type: 'bar',
    height: '40',
    barWidth: 8,
    colorMap: {
      '7': '#a1a1a1'
    },
    barSpacing: 2,
    barColor: '#26B99A'
  });

  $(".sparkline22").sparkline([2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6], {
    type: 'line',
    height: '40',
    width: '200',
    lineColor: '#26B99A',
    fillColor: '#ffffff',
    lineWidth: 3,
    spotColor: '#34495E',
    minSpotColor: '#34495E'
  });

  var cb = function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
  }
  var optionSet1 = {
    startDate: moment().subtract(29, 'days'),
    endDate: moment(),
    minDate: moment().subtract(29, 'days'),
    maxDate: moment(),
    dateLimit: {
      days: 60
    },
    showDropdowns: true,
    showWeekNumbers: true,
    timePicker: false,
    timePickerIncrement: 1,
    timePicker12Hour: true,
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    opens: 'left',
    buttonClasses: ['btn btn-default'],
    applyClass: 'btn-small btn-primary',
    cancelClass: 'btn-small',
    format: 'MM/DD/YYYY',
    separator: ' to ',
    locale: {
      applyLabel: 'Submit',
      cancelLabel: 'Clear',
      fromLabel: 'From',
      toLabel: 'To',
      customRangeLabel: 'Custom',
      daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
      monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      firstDay: 1
    }
  };

  jQuery.ajax({
    dataType: 'json',
    type: 'get',
    url: 'https://api.coinmarketcap.com/v2/ticker/?limit=10',
    data: 1,
    success: function(res) {
      $.each(res.data, function(index, val) {
        if(val.name == 'Bitcoin') {
          $('.bitcoin').html(val.quotes.USD.price);
        }
        else if (val.name == 'Ethereum') {
          $('.ether').html(val.quotes.USD.price);
        }
        // console.log(val);
      });
    },
    error: function(err) {
      console.log('ERR '+JSON.stringify(err))
    }
  });

  setTimeout(function() {
    if(contractAddress != '0' && contractAddress != '') {
      
    }
    else {

      new PNotify({
        title: "White Standard + Metamask",
        type: "error",
        text: "Please login into your Metamask and refresh this page.",
        nonblock: {
          nonblock: true
        },
        before_close: function(PNotify) {
          // You can access the notice's options with this. It is read only.
          //PNotify.options.text;

          // You can change the notice's options after the timer like this:
          PNotify.update({
            title: PNotify.options.title + " - Enjoy your Stay",
            before_close: null
          });
          PNotify.queueRemove();
          return false;
        }
      });

    }
  }, 5000);
  setTimeout(function() {
    App.getEtherBalance();
    App.getBalance();
  }, 2000);
  
})