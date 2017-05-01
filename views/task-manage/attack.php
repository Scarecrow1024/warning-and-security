<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    $this->title = '';
?>
<?=Html::jsFile('@web/js/echarts.min.js')?>
<?=Html::jsFile('@web/js/china.js')?>

<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h4 class="description-header">270</h4>
                    <span class="description-text"><i class="fa fa-fw fa-hourglass-start"></i>主机数(个)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 10%</span>
                    <h4 class="description-header">107</h4>
                    <span class="description-text"><i class="fa fa-fw fa-chrome"></i>网站数(个)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <h4 class="description-header">1200</h4>
                    <span class="description-text"><i class="fa fa-hourglass-o"></i>宕机数(次)</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- <div class="box-header with-border">
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <div class="col-md-8" style="width: 720px;height:500px;" id="main">
                    </div>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
            <div class="col-md-4">
            <div class="box">
            <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tbody><tr>
                      <th style="width: 10px">#</th>
                      <th>IP地址</th>
                      <th>归属地</th>
                      <th style="width: 25%">攻击次数</th>
                    </tr>
                    <?php for($i=0;$i<count($ips);$i++){?>
                    <tr>
                      <td><?php echo $i+1?>.</td>
                      <td><?php echo $ips[$i].".***"?></td>
                      <td>
                        <?php echo $citys[$i]?>
                      </td>
                      <td><span style="margin-left: 30%" class="badge bg-red"><?php echo $times[$i]?></span></td>
                    </tr>
                    <?php }?>
                  </tbody></table>
                </div>
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>

<script type="text/javascript">
var data = <?php echo $counts?>;
var geoCoordMap = <?php echo $coor?>;

var convertData = function (data) {
    var res = [];
    for (var i = 0; i < data.length; i++) {
        var geoCoord = geoCoordMap[data[i].name];
        if (geoCoord) {
            res.push({
                name: data[i].name,
                value: geoCoord.concat(data[i].value)
            });
        }
    }
    return res;
};

var myChart = echarts.init(document.getElementById('main'));

option = {
    backgroundColor: '#404a59',
    title: {
        text: '国内主要攻击来源散点图',
        subtext: '',
        left: 'center',
        textStyle: {
            color: '#fff'
        }
    },
    tooltip : {
        trigger: 'item'
    },
    legend: {
        orient: 'vertical',
        y: 'bottom',
        x:'right',
        data:['显示地理信息'],
        textStyle: {
            color: '#fff'
        }
    },
    geo: {
        map: 'china',
        label: {
            emphasis: {
                show: false
            }
        },
        roam: true,
        itemStyle: {
            normal: {
                areaColor: '#323c48',
                borderColor: '#111'
            },
            emphasis: {
                areaColor: '#2a333d'
            }
        }
    },
    series : [
        {
            name: '攻击次数',
            type: 'scatter',
            //type: 'map',
            //map: 'china',
            coordinateSystem: 'geo',
            data: convertData(data),
            symbolSize: function (val) {
                return val[2] / 3;
            },
            label: {
                normal: {
                    formatter: '{b}',
                    position: 'right',
                    show: false
                },
                emphasis: {
                    show: true
                }
            },
            itemStyle: {
                normal: {
                    color: '#ddb926'
                }
            }
        },
        {
            name: 'Top 5',
            type: 'effectScatter',
            coordinateSystem: 'geo',
            data: convertData(data.sort(function (a, b) {
                return b.value - a.value;
            }).slice(0, 5)),
            symbolSize: function (val) {
                return val[2] / 10;
            },
            showEffectOn: 'render',
            rippleEffect: {
                brushType: 'stroke'
            },
            hoverAnimation: true,
            label: {
                normal: {
                    formatter: '{b}',
                    position: 'right',
                    show: true
                }
            },
            itemStyle: {
                normal: {
                    color: '#f4e925',
                    shadowBlur: 10,
                    shadowColor: '#333'
                }
            },
            zlevel: 1
        }
    ]
};
myChart.setOption(option);
</script>