<?php
    require "utility.php";
    require "UserRepositoryInterface.php";
    require "UserRepository.php";
    require "session.php";

    checkEntity();

    if(!empty($_POST['submit'])){
        if($_POST['submit'] === 'Login'){
            try {
                if(empty(trim($_POST['password']))) {
                    throw new Exception("Password is invalid.");
                }

                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    throw new Exception("Email is invalid.");
                }

                $user = new UserRepository();
                $userDetail = $user->authenticate($_POST['email'], $_POST['password']);
                $_SESSION['Id'] = $userDetail['id'];
                $_SESSION['Email'] = $userDetail['email'];
                $_SESSION['Entity'] = $userDetail['entity'];
                $_SESSION['Name'] = $userDetail['name'];

                checkEntity();
            }
            catch(Exception $ex){
                $errorMessages = array();
                $errorMessages[] = $ex->getMessage();
            }
        }
    }       
?>

<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Login", array("bootstrap.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container pt-5">
           <div class="row justify-content-center">
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <h3 class="text-center">Login</h3>
                    <hr />
                    <?php 
                        if(!empty($errorMessages)){
                            Utility::loadError($errorMessages);
                        }
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" name="submit" value="Login" />
                        </div>
                    </form>
                </div>
           </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js")); ?>
        <script type="text/javascript">
            $(document).ready(
                function(){
                
                }
            );
        </script>
        <?php Utility::loadFooter(); ?>
    </body>
</html>
