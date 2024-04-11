<header>
    <div class="logo">
        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiTUKnC6ox5v-snyVif-fuzhLn6NEiphu_tKaI64y8wkwdur_vZokaHC-cObT2e7r3UZMmXBmMk0LkZw9cTUhuHG4pJNok6qdijlTtUhwq04SYQkhaAcbioHEAJRggDQLkQpwv4096VgQu8jzo5N075LYCxj38mLpfWpny_ZtBXX1_MmqFGH9i4brAabQE/s600/%5Bremoval.ai%5D_f24120a2-2c59-4feb-8e8a-dd09dcae6477-screenshot-2024-04-09-230712.png" alt="">
    </div>
    <div class="humburger">
        <i class="fa-solid fa-bars"></i>
    </div>
    <nav class="nav-bar">
        <?php

        if (!isset($_SESSION['id'])) { ?>
            <ul>
                <li><a href="/doc_care/register">Register</a></li>
                <li><a href="/doc_care/login">Login</a></li>
                <!-- <li><a href="/doc_care/doctors">Doctors</a></li>
                <li><a href="/doc_care/contact">Contact</a></li> -->
            </ul>
        <?php } else { ?>
            <ul>
                <li><a href="/doc_care/home">Dashboard</a></li>
                <li><a href="/doc_care/appointments">Appointments</a></li>
                <li><a href="/doc_care/patients">Patients</a></li>
                <li><a href="/doc_care/doctors">Doctors</a></li>
                <li>
                    <form method="POST">
                        <!-- Btn by bootstrap -->
                        <button type="submit" class="btn btn-danger" name="logout">Logout</button>
                    </form>
                </li>
            </ul>
        <?php } ?>
    </nav>
</header>