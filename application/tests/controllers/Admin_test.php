<?php 

class Admin_test extends TestCase
{
    private function set_login_session($role)
    {
        $_SESSION['id_pengguna']     = 1495442337;
        $_SESSION['hak_akses']       = $role;
    }

    public function test_index()
    {
        $output = $this->request('GET', 'admin/index');
        $this->assertRedirect('auth', 302);
    }

    public function test_logged_in()
    {
        $this->set_login_session('Admin');
        $output = $this->request('GET', 'admin/index');
        $this->assertContains('Dashboard', $output);
    }

    public function test_logged_in_not_admin()
    {
        $this->set_login_session('Pengunjung');
        $output = $this->request('GET', 'admin/index');
        $this->assertRedirect('auth', 302);    
    }

    public function test_404()
    {
        $this->set_login_session('Admin');
        $output = $this->request('GET', 'admin/4kuGantengHEHE');
        $this->assertResponseCode(404);
    }
}
