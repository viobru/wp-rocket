<?php

/**
 * Class TaskScheduler_JobStore
 */
abstract class TaskScheduler_JobStore {
	/** @var TaskScheduler_JobStore */
	private static $store = NULL;

	/**
	 * @param TaskScheduler_Job $job
	 * @return string The job ID
	 */
	abstract public function save_job( TaskScheduler_Job $job );

	/**
	 * @param string $job_id
	 * @return TaskScheduler_Job
	 */
	abstract public function fetch_job( $job_id );


	/**
	 * @param int $max_jobs
	 * @return TaskScheduler_JobClaim
	 */
	abstract public function stake_claim( $max_jobs );

	public function init() {}

	/**
	 * @return TaskScheduler_JobStore
	 */
	public static function instance() {
		if ( empty(self::$store) ) {
			$class = apply_filters('task_scheduler_job_store_class', 'TaskScheduler_wpPostJobStore');
			self::$store = new $class();
			add_action( 'init', array( self::$store, 'init' ), 10, 0 );
		}
		return self::$store;
	}
}
 