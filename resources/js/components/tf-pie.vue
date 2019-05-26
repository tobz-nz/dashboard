<template>
    <div>
        <v-chart ref="chart" style="width:320px" class="tf-pie" :options="options" :autoresize="true"></v-chart>
    </div>
</template>

<script>
    import vChart from 'vue-echarts'
    import 'echarts/lib/chart/gauge'

    export default {
        components: {
            vChart,
        },

        props: {
            value: {
                type: Number,
            },
            width: {
                type: Number,
            },
        },

        data() {
            return {
                autoresize: true,
                options: {
                    series: [{
                            name: "Volume",
                            type: "gauge",
                            splitNumber: 10,
                            axisLine: {
                                lineStyle: {
                                    color: [
                                        [this.dataValue(), this.valueColor()],
                                        [1, "hsl(207, 15%, 95%)"]
                                    ],
                                    width: 20
                                }
                            },
                            axisLabel: {
                                show: false,
                            },
                            axisTick: {
                                show: false,
                            },
                            splitLine: {
                                show: false,
                            },
                            itemStyle: {
                                show: false,
                            },
                            detail: {
                                formatter: function(value) {
                                    return `${value * 100}%`
                                },
                                offsetCenter: [0, 0],
                                textStyle: {
                                    fontSize: '42',
                                    fontFamily: 'Roboto',
                                    fontWeight: '400',
                                    color: 'hsl(207, 15%, 55%)'
                                }
                            },
                            title: {
                                offsetCenter: [0, "100%"],
                            },
                            pointer: {
                                show: false,
                            },
                            data: [{
                                "value": this.dataValue(),
                            }]
                        }
                    ]
                }
            }
        },

        computed: {
        },

        methods: {
            dataValue() {
                return this.value / 100;
            },

            valueColor() {
                let colors = {
                    low: 'hsl(6, 90%, 42%)',
                    subOptimum: 'hsl(50, 95%, 52%)',
                    optimum: 'hsl(104, 62%, 57%)',
                }

                if (this.value <= 30) {
                    return colors.low;
                }

                if (this.value > 30 && this.value <= 70) {
                    return colors.subOptimum;
                }

                if (this.value > 70) {
                    return colors.optimum;
                }

                return null;
            },
        },
    }

</script>
