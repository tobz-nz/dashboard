<template>
    <v-chart class="tf-chart" :options="options" :autoresize="true"></v-chart>
</template>

<script>
    import Moment from 'moment';
    import vChart from 'vue-echarts'
    import 'echarts/lib/chart/line'
    import 'echarts/lib/component/tooltip'

    export default {
        components: {
            vChart,
        },

        props: {
            title: {
                type: String,
                required: true,
            },
            max: {
                type: Number,
                default: 100,
            },
            data: {
                type: Array,
                required: true,
            }
        },

        data() {
            return {
                options: {
                    title: {
                        text: this.title,
                    },
                    autoresize: true,
                    tooltip: {
                        trigger: 'axis',
                        formatter: this.tooltipFormater,
                        backgroundColor: 'hsl(207, 15%, 40%)',
                        axisPointer: {
                            type: 'cross',
                            label: {
                                backgroundColor: 'hsl(207, 15%, 55%)',
                            },
                            lineStyle: {
                                color: 'hsla(207, 15%, 55%, 0.2)',
                            },
                            crossStyle: {
                                color: 'hsla(207, 15%, 55%, 0.5)',
                            }
                        }
                    },
                    xAxis: {
                        type: 'time',
                        splitLine: {
                            show: false,
                        },
                        axisLabel: {
                            color: 'hsla(207, 15%, 40%, 0.8)',
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'hsla(207, 15%, 55%, 0.4)',
                            }
                        }
                    },
                    yAxis: {
                        type: 'value',
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'hsla(207, 15%, 55%, 0.2)',
                            }
                        },
                        max: this.max,
                        axisLabel: {
                            color: 'hsla(207, 15%, 40%, 0.8)',
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'hsla(207, 15%, 55%, 0.4)',
                            }
                        }
                    },
                    animation: false,
                    series: [{
                        name: 'asdasd',
                        type: 'line',
                        showSymbol: false,
                        hoverAnimation: false,
                        smooth: 0.2,
                        lineStyle: {
                            normal: {
                                color: {
                                    type: 'linear',
                                    x: 0,
                                    y: 0,
                                    x2: 0,
                                    y2: 1,
                                    colorStops: [
                                        { offset: 0.5, color: 'hsl(205, 100%, 60%)'} ,
                                        { offset: 1, color: 'hsl(0, 78%, 58%)' },
                                    ]
                                },
                                width: 3,
                            }
                        },
                        symbolSize: 8,
                        itemStyle: {
                            normal: {
                                borderWidth: 3,
                                borderColor: 'hsl(205, 95%, 40%)',
                                color: 'hsl(205, 100%, 60%)',
                                opacity: 0.8,
                            }
                        },
                        data: this.data,
                    }]
                }
            }
        },

        computed: {},

        methods: {
            tooltipFormater(params) {
                params = params[0];
                var date = new Moment(params.name);
                return date.format('l') + ' : ' + params.value[1];
            }
        }
    }
</script>
<style>
    .tf-chart {
        width: 100%;
        height: 400px;
    }
</style>
