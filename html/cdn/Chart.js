class chartOption {

    constructor() {
        this.chart = {
            "type": "radar",
            "data": {
                "labels": [],
                "datasets": [{
                    "data": [],
                    "tension": 0,
                    "backgroundColor": "#4582cf88",
                    "borderColor": "#2f336f",
                    "pointBackgroundColor": "#2f336f",
                    "pointBorderColor": "#fff",
                    "pointHoverBackgroundColor": "#fff",
                    "pointHoverBorderColor": "#2f336f"
                }]
            },
            "options": {
                "scale": {
                    "ticks": {
                        "max": 3,
                        "min": 0,
                        "stepSize": 1
                    }
                },
                "legend": {
                    "display": false
                },
                "layout": {
                    "padding": {
                        "top": 20,
                        "left": 20,
                        "right": 20,
                        "bottom": 20
                    }
                },
                "elements": {
                    "line": {
                        "borderWidth": 3
                    }
                }
            }
        }
    }

    get option() {
        return this.chart
    }

}

class chartOptionBaton {

    static test(data, label, option = null) {
        return {
            "type": "bar",
            "data": {
                "labels": label,
                "datasets": [{
                    "data": data,
                    "backgroundColor": "#4582cf88",
                    "borderColor": "#2f336f",
                    "fill": false,
                    "hoverBackgroundColor": "#4582cf77",
                    "borderWidth": 1
                }]
            },
            "options": {
                "ticks" : option,
                "pointLabelSeperator": "\n",
                "tooltips": {
                    "enabled": false
                },
                "legend": {
                    "display": false
                },
                "layout": {
                    "padding": {
                        "top": 20,
                        "left": 20,
                        "right": 20,
                        "bottom": 20
                    }
                },
                "elements": {
                    "line": {
                        "borderWidth": 3
                    }
                },
                "scales": {
                    "yAxes": [{
                        "ticks": option
                    }],
                    "xAxes": [{
                        "maxBarThickness": 50
                    }]
                }
            }
        }
    }
}