1.  aplikasi ini memiliki level  Super Administrator, 
    yang mana tidak pernah muncul pada daftar User Level dan daftar Pengguna
    
    akun Super Administrator : 
    username : superadmin
    password : superadmin

2.  Ada fitur User Prvilege yang otomatis membaca 
    setiap function pada controller, dengan membaca komentar 1 baris setelah nama function.
    komentar haru "//-- [nama privilege]"

    autran function pada controller harus seperti ini : 

    benar : 
    function get_kategori_list(){
        //-- [Daftar Kategori]
    }

    salah : 
    function get_kategori_list()
    {
        //-- [Daftar Kategori]
    }

    salah : 
    function get_kategori_list(){
        //--[Daftar Kategori]
    }

    salah : 
    function get_kategori_list(){
        // [Daftar Kategori]
    }

    salah : 
    function get_kategori_list(){
        //- [Daftar Kategori]
    }

    salah : 
    function get_kategori_list(){
        //--- [Daftar Kategori]
    }

3.  CI ini menggunakan Engine (Class) pada folder application/libraries/
    setiap penamaan class engine diakhiri dengan _engine.php, contoh Kategori_engine.php

    Class engine ini berfungsi sebagai Table Adapter, menghubungkan antara MVC dengan Database,
    dengan ilustrasi seperti di bawah : 

    [MODEL] <----> [Engine] <----> Database

    Engine ini bersifat opsional, karena metode pemrograman kami menggunakan Engine sebagai Table Adapter (Database Helper)
