<?php
namespace App\Controllers;
use App\Models\UserModel;

class ProfileController extends BaseController
{



/**
 * Resize image to fit within maxWidth x maxHeight
 * while maintaining aspect ratio
 */
private function resizeImage(string $filePath, int $maxWidth, int $maxHeight): void
{
    $info = getimagesize($filePath);
    if (! $info) return;

    $mime = $info['mime'];

    // Load image based on type
    $source = match($mime) {
        'image/jpeg' => imagecreatefromjpeg($filePath),
        'image/png'  => imagecreatefrompng($filePath),
        'image/webp' => imagecreatefromwebp($filePath),
        'image/gif'  => imagecreatefromgif($filePath),
        default      => null,
    };

    if (! $source) return;

    $origWidth  = imagesx($source);
    $origHeight = imagesy($source);

    // Calculate new dimensions maintaining aspect ratio
    $ratio     = min($maxWidth / $origWidth, $maxHeight / $origHeight);
    $newWidth  = (int)($origWidth  * $ratio);
    $newHeight = (int)($origHeight * $ratio);

    // Create resized image
    $resized = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    if ($mime === 'image/png') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
    }

    imagecopyresampled(
        $resized, $source,
        0, 0, 0, 0,
        $newWidth, $newHeight,
        $origWidth, $origHeight
    );

    // Save resized image back to same path
    match($mime) {
        'image/jpeg' => imagejpeg($resized, $filePath, 85),
        'image/png'  => imagepng($resized, $filePath),
        'image/webp' => imagewebp($resized, $filePath, 85),
        'image/gif'  => imagegif($resized, $filePath),
        default      => null,
    };

    // Free memory
    imagedestroy($source);
    imagedestroy($resized);
}
    // SHOW — Display profile page
    public function show()
    {
        $userId = session('user')['id'] ?? session()->get('userId');
        $userModel = new UserModel();

        // Get fresh data from database
        $user = $userModel->find($userId);

        // If user not found destroy session and redirect
        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        return view('profile/show', ['user' => $user]);
    }

    // EDIT — Show edit form pre-populated with current data
    public function edit()
    {
        $userId = session('user')['id'] ?? session()->get('userId');
        $userModel = new UserModel();

        $user = $userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('login'));
        }

        return view('profile/edit', ['user' => $user]);
    }

   public function update()
{
    $userId = session('user')['id'] ?? session()->get('userId');
    $userModel = new UserModel();

    // Step 1 — Get current user record
    $user = $userModel->find($userId);

    if (! $user) {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    // Step 2 — Validate text fields
    $rules = [
        'name'       => 'required|min_length[3]',
        'email'      => "required|valid_email|is_unique[users.email,id,{$userId}]",
        'student_id' => 'required',
        'course'     => 'required',
        'year_level' => 'required|integer|greater_than[0]|less_than[6]',
        'section'    => 'required',
        'phone'      => 'required',
        'address'    => 'required',
    ];

    // Step 3 — If validation fails redirect back with errors
    if (! $this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // Step 4 — Keep old image as default
    $newImageName = $user['profile_image'];

    // Step 5 — Handle image upload if a new file was selected
$file = $this->request->getFile('profile_image');

if ($file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE) {

    // Check for upload errors including file too large
    if ($file->getError() === UPLOAD_ERR_INI_SIZE 
        || $file->getError() === UPLOAD_ERR_FORM_SIZE) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Image is too large. Please use an image under 10MB.');
    }

    if ($file->isValid() && ! $file->hasMoved()) {

        // Allowed mime types
        $allowedMimes = [
            'image/jpeg', 'image/jpg',
            'image/pjpeg', 'image/png',
            'image/webp', 'image/gif',
        ];

        if (! in_array($file->getMimeType(), $allowedMimes)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid image type. Use JPG, PNG or WEBP only.');
        }

        // Set upload path
        $uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR
                             . 'profiles' . DIRECTORY_SEPARATOR;

        // Create folder if missing
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Delete old image
        if (! empty($user['profile_image'])) {
            $oldFile = $uploadPath . $user['profile_image'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // Generate unique filename
        $ext          = $file->getClientExtension();
        $newImageName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
        $destination  = $uploadPath . $newImageName;

        // Move file first
        $file->move($uploadPath, $newImageName);

        // Resize image to max 400x400 to save space
        if (file_exists($destination)) {
            $this->resizeImage($destination, 400, 400);
        }
    }
}

    // Step 6 — Build update data
    $updateData = [
        'name'          => $this->request->getPost('name'),
        'email'         => $this->request->getPost('email'),
        'student_id'    => $this->request->getPost('student_id'),
        'course'        => $this->request->getPost('course'),
        'year_level'    => $this->request->getPost('year_level'),
        'section'       => $this->request->getPost('section'),
        'phone'         => $this->request->getPost('phone'),
        'address'       => $this->request->getPost('address'),
        'profile_image' => $newImageName,
    ];

    // Step 7 — Save to database
$db = \Config\Database::connect();
$db->table('users')->update($updateData, ['id' => $userId]);

    // Step 8 — Update session name immediately
    session()->set('userName', $this->request->getPost('name'));

    // Step 9 — Flash success and redirect
    return redirect()->to(base_url('profile'))
        ->with('success', 'Profile updated successfully!');
}
}

