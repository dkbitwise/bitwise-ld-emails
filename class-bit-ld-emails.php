<?php
/**
 * Class Bit_LD_Emails
 */
if ( ! class_exists( 'Bit_LD_Emails' ) ) {
	class Bit_LD_Emails {
		private static $ins = null;

		private $id = 0;
		private $student_id = 0;
		private $student_first_name = '';
		private $student_last_name = '';
		private $student_email = '';
		private $parent_id = 0;
		private $parent_first_name = '';
		private $parent_last_name = '';
		private $parent_email = '';
		private $course_id = 0;
		private $event_id = 0;
		private $trigger_type = '';
		private $creation_time = 0;
		private $sent_time = 0;

		private $bit_conn = null;
		private $table_name = '';
		private $table_prefix = '';

		/**
		 * Bit_LD_Emails constructor.
		 */
		public function __construct() {
			$this->table_prefix = 'bit_';
			$this->table_name   = 'ld_email_triggers';
			$this->bit_conn     = $this->get_connection();
		}

		/**
		 * @return Bit_LD_Emails|null
		 */
		public static function get_instance() {
			if ( null === self::$ins ) {
				self::$ins = new self;
			}

			return self::$ins;
		}

		public function set_id( $id ) {
			$this->id = $id;
		}

		public function set_student_id( $student_id ) {
			$this->student_id = $student_id;
		}

		public function set_student_first_name( $student_first_name ) {
			$this->student_first_name = $student_first_name;
		}

		public function set_student_last_name( $student_last_name ) {
			$this->student_last_name = $student_last_name;
		}

		public function set_student_email( $student_email ) {
			$this->student_email = $student_email;
		}

		public function set_parent_id( $parent_id ) {
			$this->parent_id = $parent_id;
		}

		public function set_parent_first_name( $parent_first_name ) {
			$this->parent_first_name = $parent_first_name;
		}

		public function set_parent_last_name( $parent_last_name ) {
			$this->parent_last_name = $parent_last_name;
		}

		public function set_parent_email( $parent_email ) {
			$this->parent_email = $parent_email;
		}

		public function set_course_id( $course_id ) {
			$this->course_id = $course_id;
		}

		public function set_event_id( $event_id ) {
			$this->event_id = $event_id;
		}

		public function set_trigger_type( $trigger_type ) {
			$this->trigger_type = $trigger_type;
		}

		public function set_creation_time( $creation_time ) {
			$this->creation_time = $creation_time;
		}

		public function set_sent_time( $sent_time ) {
			$this->sent_time = $sent_time;
		}

		public function get_id() {
			return $this->id;
		}

		public function get_student_id() {
			return $this->student_id;
		}

		public function get_student_first_name() {
			return $this->student_first_name;
		}

		public function get_student_last_name() {
			return $this->student_last_name;
		}

		public function get_student_email() {
			return $this->student_email;
		}

		public function get_parent_id() {
			return $this->parent_id;
		}

		public function get_parent_first_name() {
			return $this->parent_first_name;
		}

		public function get_parent_last_name() {
			return $this->parent_last_name;
		}

		public function get_parent_email() {
			return $this->parent_email;
		}

		public function get_course_id() {
			return $this->course_id;
		}

		public function get_event_id() {
			return $this->event_id;
		}

		public function get_trigger_type() {
			return $this->trigger_type;
		}

		public function get_creation_time() {
			return $this->creation_time;
		}

		public function get_sent_time() {
			return $this->sent_time;
		}

		public function save( $setData = array() ) {
			foreach ( is_array( $setData ) ? $setData : array() as $s_key => $s_value ) {
				$this->{$s_key} = $s_value;
			}

			$student_id = $this->get_student_id();

			$data                       = array();
			$data['student_id']         = $student_id;
			$data['student_first_name'] = empty( $this->get_student_first_name() ) ? 'NA' : $this->get_student_first_name();
			$data['student_last_name']  = $this->get_student_last_name();
			$data['student_email']      = $this->get_student_email();
			$data['parent_id']          = $this->get_parent_id();
			$data['parent_first_name']  = empty( $this->get_parent_first_name() ) ? 'NA' : $this->get_parent_first_name();
			$data['parent_last_name']   = $this->get_parent_last_name();
			$data['parent_email']       = $this->get_parent_email();
			$data['course_id']          = $this->get_course_id();
			$data['event_id']           = empty( $this->get_event_id() ) ? 0 : $this->get_event_id();
			$data['trigger_type']       = $this->get_trigger_type();
			$data['creation_time']      = $this->get_creation_time();
			$data['sent_time']          = empty( $this->get_sent_time() ) ? 0 : $this->get_sent_time();

			if ( $this->bit_conn instanceof mysqli ) {


				$columns = implode( ", ", array_keys( $data ) );
				$values  = array_values( $data );
				//$values  = implode("', '", $escaped_values);
				$final_values = '';
				$count = count($values);

				foreach ( $values as $key => $value ) {

					$final_values .= "'" . $value . "'";
					if ($key < $count-1){
						$final_values .= ",";
					}
				}
				echo '<br>' . $values . '<br>';
				$table_name = $this->table_prefix . $this->table_name;
				$final_sql  = "INSERT INTO `$table_name` ($columns) VALUES ( $final_values)";

				echo '<br>' . $final_sql . '<br>';

				$this->bit_conn->query( $final_sql );
				$message = "Inserted data for student id: $student_id";

				echo "<br>" . $message;

				if ( ! empty( $this->bit_conn->error ) ) {
					echo '<br>Error: ';
					print_r( $this->bit_conn->error );
				}
			}
		}


		public function get_connection() {
			$conn = new mysqli( "localhost", "root", "", "bitwise" );
			// Check connection
			if ( $conn->connect_errno ) {
				echo "Failed to connect to MySQL: " . $conn->connect_error;
				exit();
			}

			return $conn;
		}

		public function setup_emails() {
			$beginOfDay = strtotime( "today" );
			$endOfDay   = strtotime( "tomorrow", $beginOfDay ) - 1;

			$user_sql = "SELECT `user_id` as student_id, `meta_key` as course_key, `meta_value` as completed_time from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` LIKE '%course_completed_%' AND `meta_value` BETWEEN  '$beginOfDay' AND '$endOfDay'";
			echo '<br>' . $user_sql;
			$user_results = $this->bit_conn->query( $user_sql );
			echo '<br>' . $this->bit_conn->error;
			echo ",<br><pre>User Results: <br>";
			print_r( $user_results );

			if ( $user_results->num_rows > 0 ) {
				$first_name   = $last_name = $parent_first_name = $parent_last_name = $student_email = $parent_email = '';
				$group_id     = $parent_id = $course_id = 0;
				$trigger_type = 'course_completed';
				while ( $row = $user_results->fetch_array() ) {
					$student_id = isset( $row['student_id'] ) ? $row['student_id'] : 0;
					$course_id  = str_replace( 'course_completed_', '', $row['course_key'] );
					echo '<br>Student_id: ' . $student_id;
					if ( $student_id > 0 ) {
						$student_sql = "SELECT `meta_key`, `meta_value` from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` IN ('first_name','last_name') AND `user_id`=$student_id";
						echo '<br>' . $student_sql . '<br>';
						$student_results = $this->bit_conn->query( $student_sql );
						print_r( $student_results );
						if ( $student_results->num_rows > 0 ) {
							while ( $student_row = $student_results->fetch_assoc() ) {
								$first_name = ( 'first_name' === $student_row['meta_key'] ) ? $student_row['meta_value'] : $first_name;
								$last_name  = ( 'last_name' === $student_row['meta_key'] ) ? $student_row['meta_value'] : $last_name;
							}

							$student_email_sql = "SELECT `user_email` as student_email from " . $this->table_prefix . 'users' . " WHERE `ID`=$student_id";
							echo '<br>' . $student_email_sql . '<br>';
							$student_email_result = $this->bit_conn->query( $student_email_sql );
							print_r( $student_email_result );
							if ( $student_email_result->num_rows > 0 ) {
								while ( $email_row = $student_email_result->fetch_assoc() ) {
									$student_email = isset( $email_row['student_email'] ) ? $email_row['student_email'] : $student_email;
								}
							}

							$group_id_sql = "SELECT `meta_value` as group_id from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` LIKE '%learndash_group_users_%' AND `user_id`=$student_id";
							echo '<br>' . $group_id_sql;
							$group_id_result = $this->bit_conn->query( $group_id_sql );
							print_r( $group_id_result );
							$group_id = 0;
							if ( $group_id_result->num_rows > 0 ) {
								while ( $group_row = $group_id_result->fetch_assoc() ) {
									$group_id = isset( $group_row['group_id'] ) ? $group_row['group_id'] : $group_id;
								}
								if ( $group_id > 0 ) {
									$parent_id_sql = "SELECT `user_id` as parent_id from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` LIKE '%learndash_group_leaders_$group_id%'";
									echo '<br>' . $parent_id_sql . '<br>';
									$parent_id_result = $this->bit_conn->query( $parent_id_sql );
									print_r( $parent_id_result );
									if ( $parent_id_result->num_rows > 0 ) {
										while ( $parent_row = $parent_id_result->fetch_assoc() ) {
											$parent_id = isset( $parent_row['parent_id'] ) ? $parent_row['parent_id'] : $parent_id;
										}

										if ( $parent_id > 0 ) {
											$parent_sql = "SELECT `meta_key`, `meta_value` from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` IN ('first_name','last_name') AND `user_id`=$parent_id";
											echo '<br>' . $parent_sql . '<br>';
											$parent_results = $this->bit_conn->query( $parent_sql );
											print_r( $parent_results );
											if ( $parent_results->num_rows > 0 ) {
												while ( $parent_row = $parent_results->fetch_assoc() ) {
													$parent_first_name = ( 'first_name' === $parent_row['meta_key'] ) ? $parent_row['meta_value'] : $first_name;
													$parent_last_name  = ( 'last_name' === $parent_row['meta_key'] ) ? $parent_row['meta_value'] : $last_name;
												}
											}

											$parent_email_sql = "SELECT `user_email` as parent_email from " . $this->table_prefix . 'users' . " WHERE `ID`=$parent_id";
											echo '<br>' . $parent_email_sql . '<br>';
											$parent_email_result = $this->bit_conn->query( $parent_email_sql );
											print_r( $parent_email_result );
											if ( $parent_email_result->num_rows > 0 ) {
												while ( $email_row = $parent_email_result->fetch_assoc() ) {
													$parent_email = isset( $email_row['parent_email'] ) ? $email_row['parent_email'] : $parent_email;
												}
											}
										}
									}
								}
							}

							echo '<br>Student id: ' . $student_id;
							echo '<br>Student first name: ' . $first_name;
							echo '<br>Student last name: ' . $last_name;
							echo '<br>Student email: ' . $student_email;
							echo '<br>Parent id: ' . $parent_id;
							echo '<br>Group id: ' . $group_id;
							echo '<br>Parent first name: ' . $parent_first_name;
							echo '<br>Parent last name: ' . $parent_last_name;
							echo '<br>Parent email: ' . $parent_email;

							$this->set_student_id( $student_id );
							$this->set_student_first_name( $first_name );
							$this->set_student_last_name( $last_name );
							$this->set_student_email( $student_email );
							$this->set_parent_id( $parent_id );
							$this->set_parent_first_name( $parent_first_name );
							$this->set_parent_last_name( $parent_last_name );
							$this->set_parent_email( $parent_email );
							$this->set_course_id( $course_id );
							$this->set_event_id( $course_id );
							$this->set_trigger_type( $trigger_type );
							$this->set_creation_time( $row['completed_time'] );
							$this->set_sent_time( 0 );
							$this->save();
						}
					}
				}
			}
		}

		public function create_table() {
			$collate = "DEFAULT CHARACTER SET utf8";
			$sql     = "CREATE TABLE IF NOT EXISTS `" . $this->table_prefix . $this->table_name . "` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`student_id` INT(6) UNSIGNED NOT NULL,
				`student_first_name` VARCHAR(50) NOT NULL,
				`student_last_name` VARCHAR(50),
				`student_email` VARCHAR(100) NOT NULL,
				`parent_id` INT(6) UNSIGNED NOT NULL,
				`parent_first_name` VARCHAR(50) NOT NULL,
				`parent_last_name` VARCHAR(50),
				`parent_email` VARCHAR(100) NOT NULL,
				`event_id` INT(6) UNSIGNED,
				`trigger_type` VARCHAR(100) NOT NULL,
				`creation_time` BIGINT(20) UNSIGNED NOT NULL,
				`sent_time` BIGINT(20) UNSIGNED,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

			$result = $this->bit_conn->query( $sql );
			echo "Table created: ";
			print_r( $result );
		}
	}

	$bit_ld_emails = Bit_LD_Emails::get_instance();
	$bit_ld_emails->create_table();
	$bit_ld_emails->setup_emails();
}