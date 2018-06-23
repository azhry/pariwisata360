<?php 

class Wisata_test extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', 'wisata/index');
		$this->assertContains('Tempat Wisata', $output);
	}
}