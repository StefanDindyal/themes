(function () {
var FormatMetrics = function (selector) {
  /* Constants */
  this.METRIC_TYPE = {
    CTR: {selector: ".metric.ctr"},
    INTERACTION: {selector: ".metric.interaction"},
    COMPLETED_VIEW_RATE: {selector: ".metric.completed-view-rate"}
  };
  this.METRIC_KPI = {
    FORMAT: {selector: ".metric-kpi.format"},
    STANDARD: {selector: ".metric-kpi.standard"},
    selector: ".metric-kpi"
  };
  this.SELECTOR_METRIC_VALUE = ".metric_value";
  this.SELECTOR_METRIC_BAR = ".metric-bar";
  this.BAR_MAX_SIZE = 190;
  this.METRIC_10_MAX_VALUE = 100;
  this.METRIC_MAX_VALUE = 10;
  this.ANIMATION_DURATION = 1500;

  /* Variables */
  this.selector = selector;
  this.$element = $(selector);
  this.hasStarted = false;
  if (this.$element.length > 0) {
    this.$element.data("controller", this);
    this.init();
  }
};

FormatMetrics.prototype.init = function () {
  var self = this;
  self.$element.waypoint(function(direction) {
    if (!self.hasStarted) {
      self.hasStarted = true;
      self.animateMetrics(self.METRIC_KPI.STANDARD);
      setTimeout(function () {
        self.animateMetrics(self.METRIC_KPI.FORMAT);
      }, self.ANIMATION_DURATION);
    }
  }, {
      offset: "bottom-in-view"
  });
};

FormatMetrics.prototype.animateMetrics = function (metricKPI) {
  var self = this;
  var $metrics = self.$element.find(metricKPI.selector);
  $metrics.each(function () {
    var $metric = $(this);
    var metricValue = $metric.data("value");
    var metricRange = $metric.data("range");
    $({value: 0}).animate({value: (metricValue)}, {
      duration: self.ANIMATION_DURATION,
      easing: "easeOutExpo",
      progress: function (now, fx) {
        self.setMetricValue($metric, this.value,metricRange);
      }
    });
  });
};


FormatMetrics.prototype.setMetricValue = function ($metric, value, metricRange) {
  var max_value= (metricRange===10) ? this.METRIC_MAX_VALUE : this.METRIC_10_MAX_VALUE;
  value = (value !== isNaN) ? value : 0;
  value = (value <= max_value) ? value : max_value;
  value = (value >= 0) ? value : 0;
  var $metricValue = $metric.find(this.SELECTOR_METRIC_VALUE);
  var $metricBar = $metric.find(this.SELECTOR_METRIC_BAR);
  var barWith = (this.BAR_MAX_SIZE / 100) * (value * 100 / max_value);
  $metricValue.text(value.toFixed(1));
  $metricBar.width(barWith);
};


app.components.formatMetrics = FormatMetrics;

})();
