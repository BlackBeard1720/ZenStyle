<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Tất cả thao tác CRUD đều dùng Eloquent (Model)
     * Không dùng Query Builder (DB)
     */
    public function index(Request $request)
    {
        // Tạo query builder từ model User
        // Chưa query DB ngay, chỉ mới "chuẩn bị câu SQL"
        $query = User::with('role');
        // with('role') = eager load relation role để tránh N+1 query

        // =========================
        // FILTER THEO ID
        // =========================
        // Nếu request có truyền 'id' và không rỗng
        if ($request->filled('id')) {
            // Thêm điều kiện WHERE id = giá trị người dùng nhập
            $query->where('id', $request->id);
        }

        // =========================
        // FILTER THEO NAME
        // =========================
        // Nếu request có truyền 'name' và không rỗng
        if ($request->filled('name')) {
            // Thêm điều kiện tìm kiếm gần đúng (LIKE)
            // Ví dụ: 'alex' => '%alex%'
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // =========================
        // EXECUTE QUERY + PAGINATION
        // =========================
        // Lúc này Laravel mới thực sự query database:
        // - chạy SQL
        // - lấy dữ liệu theo trang (10 user / page)
        // - tạo pagination object
        // - withQueryString(): giữ lại ?id=...&name=... khi chuyển trang
        $users = $query->paginate(10)->withQueryString();

        // Trả dữ liệu sang view Blade
        return view('staff.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        // mã hóa mật khẩu trước khi lưu
        $data['password'] = Hash::make($data['password']);
        // mặc định tài khoản hoạt động
        $data['status'] = true;
        User::create($data);
        // redirect sau khi tạo thành công
        return redirect()->route('staff.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /*
        Tìm user trong DB có id = 5
        Nếu tìm thấy → trả về object $user
        Nếu không có → tự động 404 (khỏi viết if)
         */
        $user = User::findOrFail($id);
        // Trả dữ liệu sang view Blade
        return view('staff.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        // chỉ update password nếu có nhập
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);

        return redirect()->route('staff.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('staff.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
