<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Member;
use Illuminate\Http\UploadedFile;

class MemberTest extends TestCase
{
	use WithoutMiddleware, DatabaseMigrations;
	public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function testAddMember()
    {
        $response = $this->postJson(route('admin.add'),
            [
                'name'=>'Tung',
                'address'=>'MyDinh,HaNoi',
                'age' =>24,
            ]);
        $this->assertEquals(200,$response->status());
        $this->assertDatabaseHas(
            'members',
            [
                'id'=>1,
                'name'=>'Tung',
                'address' => 'MyDinh,HaNoi',
                'age' => 24
            ]);
    }
    public function testList()
    {
        $response = $this->getJson(route('admin.list'))->create();
        $this->assertEquals(200,$response->status());

    }
    public function testEditMember()
    {
    	$members = factory(\App\Member::class)->create();
    	$response = $this->get(route('admin.edit', ['id' => $members->id]));
    	// dd($response);
    	$response->assertStatus(200);
    }
    public function testPostEditMember()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24,
    	]);
    	$response = $this->postJson(route('admin.edit',['id' => $new->id]),[
            'name' => 'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 34,
        ]);
    	// $response = $this->call('POST',route('admin.edit' ,['id' => $new->id]),$editMember);
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',
            [
            'id' => 1,
            'name' => 'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 34,
        ]
    );
    }
    public function testDelete()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24,
    	]);
    	// $response = $this->call('GET',route('admin.delete',['id'=>$new->id]));
        $response = $this->getJson(route('admin.delete',['id'=>$new->id]));
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseMissing('members',
    		[
                'id' => 1,
    			'name' => 'Tung',
	    		'address' => 'HB',
	    		'age' => 24,
    		]);
    }
    public function testDeletePhoto()
    {
    	$image = new UploadedFile(base_path('public\images\1.jpg'),'1.jpg','image/jpg',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create(
		[
			'name' => 'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    		'photo' =>$image
		]);
		// $response = $this->call('GET',route('admin.delete',['id'=>$new->id]));
        $response = $this->getJson(route('admin.delete',['id'=>$new->id]));
		$this->assertEquals(200,$response->status());
		$this->assertDatabaseMissing('members',
			[
                'id' => 1,
				'name' => 'Tung',
	    		'address' => 'MyDinh,HaNoi',
	    		'age' => '24',
	    		'photo' =>$image
			]);

    }
    public function testAddNameEmpty()
    {
    	// $new = [
    	// 	'name'=>null,
    	// 	'address' => 'MyDinh,HaNoi',
    	// 	'age' => '24'
    	// ];
    	$response = $this->postJson(route('admin.add'),[
            'name'=>null,
            'address' => 'MyDinh,HaNoi',
            'age' => '24'
        ]);
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The name field is required.',$error);
    }
    public function testEditNameEmpty()
    {
    	$new =  Factory(\App\Member::class)->create(
		[
			'name' => 'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => 24,
		]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=> null,
            'address' => 'HB',
            'age' => 34
        ]);
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The name field is required.',$error);
    }
    public function testAddName100Character()
    {
    	// $new = [
    	// 	'name'=>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
    	// 	'address' => 'MyDinh,HaNoi',
    	// 	'age' => '24'
    	// ];
    	// $response = $this->call('POST',route('admin.add'),$new);
        $response = $this->postJson(route('admin.add'),[
            'name'=>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
            'address' => 'MyDinh,HaNoi',
            'age' => '24'
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
            [
                'id' => 1,
                'name' =>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
                'address'=>'MyDinh,HaNoi',
                'age'=>'24']);
    }
    public function testEditName100Character()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => '24',
    	]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
            'address' => 'MyDinh,HaNoi',
            'age' => '34'
        ]);
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',[
            'id'=>1,
    		'name'=>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '34'
    	]);
    }
    public function testAddNameGreaterThan100Character()
    {
    	$response = $this->postJson(route('admin.add'),
        [
            'name'=>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop1',
            'address' => 'MyDinh,HaNoi',
            'age' => '24'
        ]);
    	$error = $response->exception->validator->messages()->first();
        $this->assertEquals('The name may not be greater than 100 characters.',$error);
    }
    public function testEditNameGreaterThan100Character()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24,
    	]);
    	$response = $this->call('POST',route('admin.edit',['id' => $new->id]),
            [
                'name'=>'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopq',
                'address' => 'MyDinh,HaNoi',
                'age' => 34
            ]
        );
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The name may not be greater than 100 characters.',$error);
    }
    public function testAddAddressEmpty()
    {
    	$response = $this->postJson(route('admin.add'),
        [
            'name'=>'Tung',
            'address' => null,
            'age' => 24
        ]);
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The address field is required.',$error);
    }
    public function testEditAddressEmpty()
    {
    	$new =  Factory(\App\Member::class)->create(
		[
			'name' => 'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => 24,
		]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),
            [
                'id' => 1,
                'name'=>'AAAAA',
                'address' => null,
                'age' => 34
        ]
        );
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The address field is required.',$error);
    }
    public function testAddAddress300Character()
    {
    	/*$new = [
    		'name'=>'Tung',
    		'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
    		'age' => '24'
    	];*/
    	$response = $this->postJson(route('admin.add'),
            [
                'name'=>'Tung',
                'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
                'age' => 24
            ]
        );
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',[
            'id' =>1,
    		'name'=>'Tung',
    		'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
    		'age' => '24'
    	]);
    }
    public function testEditAddress300Character()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => '24',
    	]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),
            [
            'name'=>'aaaa',
            'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
            'age' => 34
            ]
        );
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',[
            'id' => 1,
    		'name'=>'aaaa',
    		'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiop',
    		'age' => 34
    	]);
    }
    public function testAddAddressGreaterThan300Character()
    {
    	$response = $this->postJson(route('admin.add'),
            [
                'name'=>'Tung',
                'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopq',
                'age' => 24
            ]
        );
    	$error = $response->exception->validator->messages()->first();
        $this->assertEquals('The address may not be greater than 300 characters.',$error);
    }
    public function testEditAddressGreaterThan300Character()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => '24',
    	]);
    	$response = $this->postJson(route('admin.edit',['id' => $new->id]),
            [
            'name'=>'aaaa',
            'address' => 'qưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopqưertyuiopq',
            'age' => 34
        ]
        );
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The address may not be greater than 300 characters.',$error);
    }
    public function testAddAgeEmpty()
    {
    	$response = $this->postJson(route('admin.add'),
            [
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => null
            ]
        );
    	$error = $response->exception->validator->messages()->first();
    	// dd($error);
        $this->assertEquals('The age field is required.',$error);
    }
	public function testEditAgeEmpty()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24,
    	]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),
            [
                'name'=>'aaaa',
                'address' => 'MyDinh,HaNoi',
                'age' => null
            ]
        );
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The age field is required.',$error);
    }
    public function testAddAge2Numeral()
    {
    	$response = $this->postJson(route('admin.add'),
            [
                'name'=>'Tung',
                'address' => 'MyDinh,HaNoi',
                'age' => 99
            ]
        );
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',[
            'id' => 1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => 99
    	]);
    }
    public function testEditAge2Numeral()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24
    	]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),
            [
                'name'=>'aaaa',
                'address' => 'MyDinh,HaNoi',
                'age' => 99
            ]
        );
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',[
            'id' => 1,
    		'name'=>'aaaa',
    		'address' => 'MyDinh,HaNoi',
    		'age' => 99
    	]);
    }
    public function testAddAgeGreaterThan2Numeral()
    {
    	$response = $this->postJson(route('admin.add'),
            [
                'name'=>'Tung',
                'address' => 'MyDinh,HaNoi',
                'age' => 100
            ]
        );
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The age may not be greater than 2 Numeral.',$error);
    }
    public function testEditAgeGreaterThan2Numeral()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24
    	]);
    	$edit = [
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => 100
    	];
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),
            [
                'name'=>'Tung',
                'address' => 'MyDinh,HaNoi',
                'age' => 100
            ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The age may not be greater than 2 Numeral.',$error);
    }
    public function testAddAgeNotNumber()
    {
    	$response = $this->postJson(route('admin.add'),
            [
                'name'=>'Tung',
                'address' => 'MyDinh,HaNoi',
                'age' => 'aaa'
            ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The age must be a number.',$error);
    }
    public function testEditAgeNotNumber()
    {
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'Tung',
    		'address' => 'HB',
    		'age' => 24
    	]);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 'aaa'
        ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The age must be a number.',$error);
    }
    public function testAddImageFileJPG()
    {
    	$image = new UploadedFile(base_path('public\images\1.jpg'),'1.jpg','image/jpg',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.add'),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $image
        ]);
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',
    		[
            'id'=>1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => 24,
    	]);
    }
    public function testEditImageFileJPG()
    {
    	$image = new UploadedFile(base_path('public\images\1.jpg'),'1.jpg','image/jpg',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'aaaa',
    		'address' => 'HB',
    		'age' => 2,
    		'photo' => $image
    	]);
    	$imgedit = new UploadedFile(base_path('public\images\user4-128x128.jpg'),'user4-128x128.jpg','image/jpg',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $imgedit
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
    		[
            'id' => 1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testAddImageFilePNG()
    {
    	$image = new UploadedFile(base_path('public\images\Coder-PNG-Clipart.png'),'Coder-PNG-Clipart.png','image/png',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.add'),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => '24',
            'photo' => $image
        ]);
    	$this->assertEquals(200,$response->status());
    	$this->assertDatabaseHas('members',
    		[
            'id' => 1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testEditImageFilePNG()
    {
    	$image = new UploadedFile(base_path('public\images\Coder-PNG-Clipart.png'),'Coder-PNG-Clipart.png','image/png',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'aaaa',
    		'address' => 'HB',
    		'age' => 2,
    		'photo' => $image
    	]);
    	$imgedit = new UploadedFile(base_path('public\images\1.png'),'1.png','image/png',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $imgedit
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
    		[
            'id'=>1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testAddImageFileGIF()
    {
    	$image = new UploadedFile(base_path('public\images\2.gif'),'2.gif','image/gif',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.add'),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => '24',
            'photo' => $image
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
    		[
            'id' =>1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testEditImageFileGIF()
    {
    	$image = new UploadedFile(base_path('public\images\2.gif'),'2.gif','image/gif',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'aaaa',
    		'address' => 'HB',
    		'age' => 2,
    		'photo' => $image
    	]);
    	$imgedit = new UploadedFile(base_path('public\images\3.gif'),'3.gif','image/gif',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $imgedit
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
    		[
            'id' =>1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testAddImageIncorrectFormat()
    {
    	$image = new UploadedFile(base_path('public\images\IMG_6044.bmp'),'IMG_6044.bmp','image/bmp',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.add'),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => '24',
            'photo' => $image
        ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The photo must be a file of type: jpeg, png, gif.',$error);
    }
    public function testEditImageIncorrectFormat()
    {
    	$image = new UploadedFile(base_path('public\images\IMG_6044.bmp'),'IMG_6044.bmp','image/bmp',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'aaaa',
    		'address' => 'HB',
    		'age' => 2,
    		'photo' => $image
    	]);
    	$imgedit = new UploadedFile(base_path('public\images\1.bmp'),'1.bmp','image/bmp',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $imgedit
        ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The photo must be a file of type: jpeg, png, gif.',$error);
    }
    public function testAddImageLessThan10MB()
    {
    	$image = new UploadedFile(base_path('public\images\1.jpg'),'1.jpg','image/jpg',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.add'),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => '24',
            'photo' => $image
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
    		[
            'id' =>1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testEditImageLessThan10MB()
    {
    	$image = new UploadedFile(base_path('public\images\1.jpg'),'1.jpg','image/jpg',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'aaaa',
    		'address' => 'HB',
    		'age' => 2,
    		'photo' => $image
    	]);
    	$imgedit = new UploadedFile(base_path('public\images\IMG_1145.jpg'),'IMG_1145.jpg','image/jpg',111,$error = null,$test = true);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $imgedit
        ]);
    	$this->assertEquals(200,$response->status());
    	// dd($response);
    	$this->assertDatabaseHas('members',
    		[
            'id'=>1,
    		'name'=>'Tung',
    		'address' => 'MyDinh,HaNoi',
    		'age' => '24',
    	]);
    }
    public function testAddImageBiggerThan10MB()
    {
    	$image = new UploadedFile(base_path('public\images\55.jpg'),'55.jpg','image/jpg',10485760,$error = null,$test = true);
    	$response = $this->postJson(route('admin.add'),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => '24',
            'photo' => $image
        ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The photo may not be greater than 10MB.',$error);
    }
    public function testEditImageBiggerThan10MB()
    {
    	$image = new UploadedFile(base_path('public\images\Lung-van-noc-nha-xu-muong-mytour-1.jpg'),'Lung-van-noc-nha-xu-muong-mytour-1.jpg','image/jpg',111,$error = null,$test = true);
    	$new = Factory(\App\Member::class)->create([
    		'name' => 'aaaa',
    		'address' => 'HB',
    		'age' => 2,
    		'photo' => $image
    	]);
    	$imgedit = new UploadedFile(base_path('public\images\66.jpg'),'66.jpg','image/jpg',10485760,$error = null,$test = true);
    	$response = $this->postJson(route('admin.edit',['id'=>$new->id]),[
            'name'=>'Tung',
            'address' => 'MyDinh,HaNoi',
            'age' => 24,
            'photo' => $imgedit
        ]);
    	$error = $response->exception->validator->messages()->first();
		// dd($error);
    	$this->assertEquals('The photo may not be greater than 10MB.',$error);
    }
}
