<?php
/* This components shows a graphical representation of the format's metrics.
 * @param int (format): Id of a term of type format.
 * USAGE:
 * render_component("format-metrics", array("format" => 123));
 */

 $format = new WP_Query(array("post_type" => "format", "post__in" => array($this->format)));
 $format = $format->posts[0];
 $elementID = "format-metrics-component-" . uniqid();
 /* Begin metrics fields */
 /* This metrics are attach to a format, so we are reading the data from the custom fields here. */
 $ctr = get_field("ctr", $format->ID) ? get_field("ctr", $format->ID) : 1;
 $ctrSD = get_field("ctr_sd", $format->ID) ? get_field("ctr_sd", $format->ID) : 1;
 $interaction = get_field("interaction", $format->ID) ? get_field("interaction", $format->ID) : 1;
 $interactionSD = get_field("interaction_sd", $format->ID) ? get_field("interaction_sd", $format->ID) : 1;
 $cvr = get_field("cvr", $format->ID) ? get_field("cvr", $format->ID) : 1;
 $cvrSD = get_field("cvr_sd", $format->ID) ? get_field("cvr_sd", $format->ID) : 1;
 /* End metrics fields */

 /* This is just a custom data array, to avoid repeating the same template markup for the 3 metrics */
 $metrics = array(
   array("class" => "ctr", "title" => "CTR", "format_value" => $ctr, "standard_value" => $ctrSD,"range" => 10),
   array("class" => "interaction", "title" => "INTERACTION TIME", "format_value" => $interaction, "standard_value" => $interactionSD,"range" => 10),
   array("class" => "completed-view-rate", "title" => "ENGAGEMENT RATE", "format_value" => $cvr, "standard_value" => $cvrSD,"range" => 100)
  );
?>

<div class="format-metrics-component" id="<?php echo $elementID ?>">
  <?php if ($format) : ?>
  <?php foreach ($metrics as $metric) : ?>
  <section class="metric ctr">
    <h1 class="metric-title"><?php echo $metric["title"]; ?></h2>
    <figure class="metric-graphic">
      <div class="metric-kpi format" data-value="<?php echo $metric["format_value"]; ?>" data-range="<?php echo $metric["range"]; ?>">
        <div class="metric-bar"></div>
        <?php if($metric["range"]=== 100){?>
            <div class="metric-label"><span class="metric_value porcentage_value">0.0</span>[<?php echo $format->post_title; ?>]</div>
        <?php }else{ ?>
            <div class="metric-label"><span class="metric_value ">0.0</span>[<?php echo $format->post_title; ?>]</div>
        <?php } ?>
      </div>
      <div class="metric-kpi standard" data-value="<?php echo $metric["standard_value"]; ?>">
        <div class="metric-bar"></div>
        <?php if($metric["range"]=== 100){?>
            <div class="metric-label"><span class="metric_value porcentage_value">0.0</span> [Standard Display]</div>
        <?php }else{ ?>
            <div class="metric-label"><span class="metric_value ">0.0</span> [Standard Display]</div>
        <?php } ?>
      </div>
    </figure>
  </section>
  <?php endforeach;?>

<script>
  $(document).ready(function () {
    new app.components.formatMetrics("<?php echo '#' . $elementID ?>");
  });
</script>
<?php endif; ?>
</div>
