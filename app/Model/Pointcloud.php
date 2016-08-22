<?php
/**
 * Point Clouds Model
 *
 * PoointClouds represents the frames and streams of the point clouds
 *
 * @author		Carl Saldanha - csaldanha3@gatech.edu
 * @copyright	2016 Georgia Institute of Technology
 * @link		https://github.com/GT-RAIL/rms
 * @since		RMS v 2.0.0
 * @version		2.0.9
 * @package		app.Model
 */
class Pointcloud extends AppModel {

/**
 * The validation criteria for the model.
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid ID.',
				'required' => 'update'
			),
			'gt' => array(
				'rule' => array('comparison', '>', 0),
				'message' => 'IDs must be greater than 0.',
				'required' => 'update'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This user ID already exists.',
				'required' => 'update'
			)
		),
		'topic' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid ROS point cloud topic.',
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Topics cannot be longer than 255 characters.',
				'required' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This name already exists.',
				'required' => true
			)
		),
		'stream' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Hosts cannot be longer than 255 characters.',
				'required' => true
			)
		),
		'tf_frame' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid TF Frame for the camera',
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Hosts cannot be longer than 255 characters.',
				'required' => true
			)
		),
		'environment_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid environment.',
				'required' => true
			),
			'gt' => array(
				'rule' => array('comparison', '>', 0),
				'message' => 'Environment IDs must be greater than 0.',
				'required' => true
			)
		),
		'created' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid creation time.',
				'required' => 'create'
			)
		),
		'modified' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a valid modification time.',
				'required' => true
			)
		)
	);

/**
 * All point clouds belong to a single environment.
 *
 * @var string
 */
	public $belongsTo = 'Environment';
}
