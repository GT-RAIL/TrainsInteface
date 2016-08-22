<?php
/**
 * Point Cloud Servers Controller
 *
 * A List of the streams for point clouds and other things
 *
 * @author		Russell Toris - rctoris@wpi.edu
 * @copyright	2014 Worcester Polytechnic Institute
 * @link		https://github.com/WPI-RAIL/rms
 * @since		RMS v 2.0.0
 * @version		2.0.9
 * @package		app.Controller
 */
class PointcloudsController extends AppController {

/**
 * The used helpers for the controller.
 *
 * @var array
 */
	public $helpers = array('Html', 'Form', 'Rms');

/**
 * The used components for the controller.
 *
 * @var array
 */
	public $components = array('Session', 'Auth' => array('authorize' => 'Controller'));

/**
 * The admin index action redirects to the main widget index.
 *
 * @return null
 */
	public function admin_index() {
		return $this->redirect(array('controller' => 'widget', 'action' => 'index', '#' => 'pointclouds'));
	}

/**
 * The admin add action. This will allow the admin to create a new entry.
 *
 * @return null
 */
	public function admin_add() {
		// load the environments list
		$environments = $this->Pointcloud->Environment->find('list');
		$this->set('environments', $environments);

		// only work for POST requests
		if ($this->request->is('post')) {
			// create a new entry
			$this->Pointcloud->create();
			// check for empty values
			if (strlen($this->request->data['Pointcloud']['stream']) === 0) {
				$this->request->data['Pointcloud']['stream'] = null;
			}
			if (strlen($this->request->data['Pointcloud']['tf_frame']) === 0) {
				$this->request->data['Pointcloud']['tf_frame'] = null;
			}
			// set the current timestamp for creation and modification
			$this->Pointcloud->data['Pointcloud']['created'] = date('Y-m-d H:i:s');
			$this->Pointcloud->data['Pointcloud']['modified'] = date('Y-m-d H:i:s');
			// attempt to save the entry
			if ($this->Pointcloud->save($this->request->data)) {
				$this->Session->setFlash('The Pointcloud has been saved.');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('Unable to add the Pointcloud.');
		}

		$this->set('title_for_layout', 'Add Pointcloud');
	}

/**
 * The admin edit action. This allows the admin to edit an existing entry.
 *
 * @param int $id The ID of the entry to edit.
 * @throws NotFoundException Thrown if an entry with the given ID is not found.
 * @return null
 */
	public function admin_edit($id = null) {
		// load the environments list
		$environments = $this->Pointcloud->Environment->find('list');
		$this->set('environments', $environments);

		if (!$id) {
			// no ID provided
			throw new NotFoundException('Invalid pointcloud.');
		}

		$pointcloud = $this->Pointcloud->findById($id);
		if (!$pointcloud) {
			// no valid entry found for the given ID
			throw new NotFoundException('Invalid pointcloud.');
		}

		// only work for PUT requests
		if ($this->request->is(array('pointcloud', 'put'))) {
			// set the ID
			$this->Pointcloud->id = $id;
			// check for empty values
			if (strlen($this->request->data['Pointcloud']['stream']) === 0) {
				$this->request->data['Pointcloud']['stream'] = null;
			}
			if (strlen($this->request->data['Pointcloud']['tf_frame']) === 0) {
				$this->request->data['Pointcloud']['tf_frame'] = null;
			}
			// set the current timestamp for modification
			$this->Pointcloud->data['Pointcloud']['modified'] = date('Y-m-d H:i:s');
			// attempt to save the entry
			if ($this->Pointcloud->save($this->request->data)) {
				$this->Session->setFlash('The Point cloud has been updated.');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('Unable to update the Point Cloud.');
		}

		// store the entry data if it was not a PUT request
		if (!$this->request->data) {
			$this->request->data = $pointcloud;
		}

		$this->set('title_for_layout', __('Edit Point Cloud - %s', $pointcloud['Pointcloud']['topic']));
	}

/**
 * The admin delete action. This allows the admin to delete an existing entry.
 *
 * @param int $id The ID of the entry to delete.
 * @throws MethodNotAllowedException Thrown if a GET request is made.
 * @return null
 */
	public function admin_delete($id = null) {
		// do not allow GET requests
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		// attempt to delete the entry
		if ($this->Pointcloud->delete($id)) {
			$this->Session->setFlash('The MJPEG stream has been deleted.');
			return $this->redirect(array('action' => 'index'));
		}
	}

/**
 * View the given entry.
 *
 * @param int $id The ID of the entry to view.
 * @throws NotFoundException Thrown if an entry with the given ID is not found.
 * @return null
 */
	public function admin_view($id = null) {
		if (!$id) {
			// no ID provided
			throw new NotFoundException('Invalid stream.');
		}

		$this->Pointcloud->recursive = 2;
		$pointcloud = $this->Pointcloud->findById($id);
		if (!$pointcloud) {
			// no valid entry found for the given ID
			throw new NotFoundException('Invalid stream.');
		}

		// store the entry
		$this->set('stream', $pointcloud);
		$this->set('title_for_layout', $pointcloud['Pointcloud']['topic']);
	}
}
