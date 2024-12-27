<script>
    function toast($message, $type) {
        switch ($type) {
            case 'success':
                $bg = 'bg-green-800';
                $title = 'Success';
                break;
            case 'error':
                $bg = 'bg-red-800';
                $title = 'Error';
                break;
            case 'warning':
                $bg = 'bg-yellow-800';
                $title = 'Warning';
                break;
            default:
                $bg = 'bg-blue-800';
                $title = 'Information';
                break;
        }
        $('#liveToast h4').text($title);
        $('#liveToast .toast').removeClass().addClass('toast p-4 rounded-lg w-full text-white ' + $bg);
        $('#liveToast .toast-body').text($message);
        $('#liveToast').removeClass('hidden');
        $('#liveToast').slideDown(400);
        setTimeout(function() {
            $('#liveToast').slideUp(400);
            $('#liveToast').addClass('hidden');
        }, 5000);
    }
</script>
<div id="liveToast" class="fixed top-0 left-1/2 transform -translate-x-1/2 hidden mt-6 w-64 bg-red-700 rounded">
    <div class="rounded w-full p-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="text-white mt-1 ms-1 text-sm">
            <strong class="">Error</strong>
        </div>
        <div class="text-white text-center">
            Change password token is invalid or expired, please request a new one by clicking on the forgot password link
        </div>
    </div>
</div>
<?php

$user = new User();
$user->loadByPasswordChange($_GET['passwordChange']);
if (!(isset($user->id))) {
    echo '<script>console.log("Error loading user");</script>';
    echo '<script>toast("Token not valid or already expired", "error");</script>';
    echo '<script>setTimeout(function() { window.location.href = "index.php"; }, 300000);</script>';
} else {
?>
    <div class="w-full md:w-1/3 flex flex-col mx-auto mt-5 border-2 border-sky-950 p-5 mb-5 rounded h-80">
        <h4 class="text-center">
            Changing password for
        </h4>
        <h5 class="text-lg font-bold text-center text-sky-950"><?php echo $user->firstName . ' ' . $user->lastName; ?></h5>
        <div class="flex flex-row justify-center">
            <div class="flex flex-col w-1/2">
                <div class="form-group mt-3 flex flex-col">
                    <label for="password" class="text-sky-950 font-bold">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group mt-3 flex flex-col">
                    <label for="confirmPassword" class="text-sky-950 font-bold">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="flex justify-end mt-2">
                    <button id="changePasswordButton" type="button" class="btn-success w-1/3">Ok</button>
                </div>
            </div>
            <div class="ms-5">
                <div class="mt-5 text-green-800 font-bold">The new password must include</div>
                <ul class="text-sky-950 text-xs" id="passwordRequirements">
                    <li class="text-red-800"><i class="fa-solid fa-x text-red-800 me-3"></i>At least 8 characters xxxxxxxx</li>
                    <li class="text-red-800"><i class="fa-solid fa-x text-red-800 me-3"></i>At least one uppercase letter A-Z</li>
                    <li class="text-red-800"><i class="fa-solid fa-x text-red-800 me-3"></i>At least one lowercase letter a-z</li>
                    <li class="text-red-800"><i class="fa-solid fa-x text-red-800 me-3"></i>At least one number 0-9</li>
                    <li class="text-red-800"><i class="fa-solid fa-x text-red-800 me-3"></i>At least one special character !@#$%?</li>
                    <li class="text-red-800"><i class="fa-solid fa-x text-red-800 me-3"></i>Confirm password</li>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function() {
        $('#password').on('keyup', function() {
            let password = $(this).val();
            let passwordMatch = $('#confirmPassword').val();
            let passwordLength = password.length;
            $('#passwordRequirements li:nth-child(1)').removeClass();
            $('#passwordRequirements li:nth-child(1) i').removeClass();
            if (passwordLength >= 8) {
                $('#passwordRequirements li:nth-child(1)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(1) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(1)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(1) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
            $('#passwordRequirements li:nth-child(2)').removeClass();
            $('#passwordRequirements li:nth-child(2) i').removeClass();
            if (password.match(/[A-Z]/)) {
                $('#passwordRequirements li:nth-child(2)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(2) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(2)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(2) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
            $('#passwordRequirements li:nth-child(3)').removeClass();
            $('#passwordRequirements li:nth-child(3) i').removeClass();
            if (password.match(/[a-z]/)) {
                $('#passwordRequirements li:nth-child(3)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(3) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(3)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(3) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
            $('#passwordRequirements li:nth-child(4)').removeClass();
            $('#passwordRequirements li:nth-child(4) i').removeClass();
            if (password.match(/[0-9]/)) {
                $('#passwordRequirements li:nth-child(4)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(4) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(4)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(4) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
            $('#passwordRequirements li:nth-child(5)').removeClass();
            $('#passwordRequirements li:nth-child(5) i').removeClass();
            if (password.match(/[!@#$%?]/)) {
                $('#passwordRequirements li:nth-child(5)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(5) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(5)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(5) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
            $('#passwordRequirements li:nth-child(6)').removeClass();
            $('#passwordRequirements li:nth-child(6) i').removeClass();
            if (password === passwordMatch) {
                $('#passwordRequirements li:nth-child(6)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(6) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(6)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(6) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
        });
        $('#confirmPassword').on('keyup', function() {
            let password = $('#password').val();
            let passwordMatch = $(this).val();
            console.log(password + ' matching ' + passwordMatch);
            $('#passwordRequirements li:nth-child(6)').removeClass();
            $('#passwordRequirements li:nth-child(6) i').removeClass();
            if (password === passwordMatch) {
                $('#passwordRequirements li:nth-child(6)').addClass('text-green-800');
                $('#passwordRequirements li:nth-child(6) i').addClass('fa-solid fa-check text-green-800 me-3');
            } else {
                $('#passwordRequirements li:nth-child(6)').addClass('text-red-800');
                $('#passwordRequirements li:nth-child(6) i').addClass('fa-solid fa-x text-red-800 me-3');
            }
        });
    });
    $('#changePasswordButton').on('click', function() {

        let password = $('#password').val();
        let passwordMatch = $('#confirmPassword').val();
        let passwordRequirementsMet = true;

        // Add all password requirements here
        if (password.length < 8) {
            passwordRequirementsMet = false;
            toast('Password must be at least 8 characters long', 'error');
            return;
        }
        if (password.match(/[A-Z]/) == null) {
            passwordRequirementsMet = false;
            toast('Password must contain at least one uppercase letter', 'error');
            return;
        }
        if (password.match(/[a-z]/) == null) {
            passwordRequirementsMet = false;
            toast('Password must contain at least one lowercase letter', 'error');
            return;
        }
        if (password.match(/[0-9]/) == null) {
            passwordRequirementsMet = false;
            toast('Password must contain at least one number', 'error');
            return;
        }
        if (password.match(/[!@#$%?]/) == null) {
            passwordRequirementsMet = false;
            toast('Password must contain at least one special character', 'error');
            return;
        }
        if (password !== passwordMatch) {
            passwordRequirementsMet = false;
            toast('Passwords do not match', 'error');
            return;
        }
        let passwordChange = '<?php echo $_GET['passwordChange']; ?>';
        $.post('../controllers/Login.php', {
            passwordChange: passwordChange,
            password: password,
            action: 'changePassword'
        }).done(function(resp) {
            resp = JSON.parse(resp);
            if (resp.status === 'success') {
                toast('Password changed successfully', 'success');
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 300000);
            } else {
                toast('Error changing password', 'error');
            }
        });
    });
</script>