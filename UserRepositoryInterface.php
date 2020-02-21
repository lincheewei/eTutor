<?php
    namespace App\Repositories\Users;

    interface UserRepositoryInterface {
        public function authenticate($username, $password);
        public function verifyTutor($tutor);
        public function verifyStudent($student);
    }
