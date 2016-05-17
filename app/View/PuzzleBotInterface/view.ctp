<?php
/**
 * Puzzle Bot Interface
 *
 * The Puzzle Bot view. This interface will for testing queuing and chat.
 *
 * @author		Carl Saldanha csaldanha3@gatech.edu
 * @copyright	2015 Georgia Institute of Technology
 * @link		none 
 * @since		TrainsInterface v 0.0.1
 * @version		0.0.1
 * @package		app.Controller
 */
?>
<html>
<head>

	<?php
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->css('bootstrap.min');
		echo $this->Rms->ros($environment['Rosbridge']['uri']);
		//Init study information
		echo $this->Rms->initStudy();
	?>
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/EventEmitter/5.0.0/EventEmitter.js'></script>
	<script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.1/fabric.min.js'></script>
	
	<?php echo $this->Html->script('mjpegcanvas2.js');?>

	<?php
		echo $this->Rms->tf(
    		$environment['Tf']['frame'],
    		$environment['Tf']['angular'],
    		$environment['Tf']['translational'],
    		$environment['Tf']['rate']
		);
	?>

</head>


<body>
	<div id="mjpeg"></div>
</body>

	<script type="text/javascript">
		var size = Math.min(((window.innerWidth / 2) - 120), window.innerHeight * 0.60);
		<?php
			$streamTopics = '[';
			$streamNames = '[';
			foreach ($environment['Stream'] as $stream) {
				$streamTopics .= "'" . $stream['topic'] . "', ";
				$streamNames .= "'" . $stream['name'] . "', ";
			}
			// remove the final comma
			$streamTopics = substr($streamTopics, 0, strlen($streamTopics) - 2);
			$streamNames = substr($streamNames, 0, strlen($streamNames) - 2);
			$streamTopics .= ']';
			$streamNames .= ']';
		?>
		console.log(EventEmitter)
	    var mjpegcanvas=new MJPEGCANVAS.MultiStreamViewer({
			divID: 'mjpeg',
			host: '<?php echo $environment['Mjpeg']['host']; ?>',
			port: <?php echo $environment['Mjpeg']['port']; ?>,
			width: size,
			height: size * 0.85,
			quality: <?php echo $environment['Stream']?(($environment['Stream'][0]['quality']) ? $environment['Stream'][0]['quality'] : '90'):''; ?>,
			topics: <?php echo $streamTopics; ?>,
			labels: <?php echo $streamNames; ?>,
			tfObject:_TF,
			tf:'arm_mount_plate_link'
		},EventEmitter);
	    //add a set of interactive markers
	  //  mjpegcanvas.addTopic('/tablebot_interactive_manipulation/update_full','visualization_msgs/InteractiveMarkerInit')

	</script>
</html>