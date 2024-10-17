    <?php

    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\DocumentController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\UserDocumentController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    });



    // Routes for admin access only
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::resource('admin/documents', DocumentController::class);

        //ROute to show the admin dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Route to show the index page for managing documents
        Route::get('/admin/documents', [DocumentController::class, 'index'])->name('admin.documents.index');

        // Route to show the form for creating a new folder
        Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('admin.documents.create');

        // Route to store the new folder
        Route::post('/admin/documents/store', [DocumentController::class, 'store'])->name('admin.documents.store');

        // Route to view a specific folder and its contents
        Route::get('/admin/documents/{folder}', [DocumentController::class, 'show'])->name('admin.documents.show');

        #Route::get('/document/open/{id}', [DocumentController::class, 'open'])->name('document.open');



        Route::get('/admin/documents/{folder}/grant-access', [DocumentController::class, 'grantAccess'])->name('admin.documents.grant-access');
        Route::post('/admin/documents/access', [DocumentController::class, 'storeAccess'])->name('admin.documents.store-access');

    });

    Route::get('/documents/{id}/open', [UserDocumentController::class, 'open'])->name('document.open');

    // Routes for user access only
    Route::middleware(['auth', 'user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/user/documents', [UserDocumentController::class, 'index'])->name('user.documents.index');
        Route::get('/user/documents/{folder}', [UserDocumentController::class, 'show'])->name('user.documents.show');
        Route::get('/document/view/{id}', [DocumentController::class, 'view'])->name('document.view');
        
    });


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
