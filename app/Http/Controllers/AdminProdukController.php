<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Support\CloudinaryStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProdukController extends Controller
{
    public function __construct(private readonly CloudinaryStorage $cloudinary)
    {
    }

    public function index(): View
    {
        $produk = Produk::latest()->paginate(10);

        return view('admin.produk.index', compact('produk'));
    }

    public function create(): View
    {
        return view('admin.produk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['slug'] = $this->uniqueSlug($validated['nama']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['gambar'] = $request->hasFile('gambar')
            ? $this->cloudinary->upload($request->file('gambar'))
            : null;

        Produk::create($validated);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $produk = Produk::findOrFail($id);

        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $produk = Produk::findOrFail($id);
        $validated = $request->validate($this->rules());

        $validated['slug'] = $this->uniqueSlug($validated['nama'], $produk->id);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('gambar')) {
            $newImage = $this->cloudinary->upload($request->file('gambar'));

            if ($newImage !== null) {
                $this->cloudinary->delete($produk->gambar);
                $validated['gambar'] = $newImage;
            }
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $produk = Produk::findOrFail($id);
        $this->cloudinary->delete($produk->gambar);
        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:4096'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (Produk::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
