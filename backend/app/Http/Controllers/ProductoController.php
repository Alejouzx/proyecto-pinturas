<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'acabado']);

        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'ilike', "%{$nombre}%");
        }

        if ($request->filled('categoria')) {
            $categoria = $request->input('categoria');
            $query->whereHas('categoria', fn ($q) => $q->where('nombre', 'ilike', "%{$categoria}%"));
        }

        if ($request->filled('tipo')) {
            $tipo = $request->input('tipo');
            $query->whereHas('categoria', fn ($q) => $q->where('nombre', 'ilike', "%{$tipo}%"));
        }

        if ($request->filled('acabado')) {
            $acabado = $request->input('acabado');
            $query->whereHas('acabado', fn ($q) => $q->where('nombre', 'ilike', "%{$acabado}%"));
        }

        if ($request->filled('color')) {
            $color = $request->input('color');
            $query->where(function ($q) use ($color) {
                $q->where('nombre_color', 'ilike', "%{$color}%")
                  ->orWhere('codigo_color_hex', 'ilike', "%{$color}%");
            });
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->input('precio_min'));
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->input('precio_max'));
        }

        if ($request->boolean('disponibles')) {
            $query->disponibles();
        }

        if ($request->boolean('destacados')) {
            $query->where('stock', '>', 0)->orderByDesc('stock')->limit(4);
        } else {
            $query->orderBy('nombre');
        }

        return response()->json($query->get(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'marca'            => 'nullable|string|max:100',
            'categoria_id'     => 'required|exists:categorias,id',
            'acabado_id'       => 'required|exists:acabados,id',
            'codigo_color_hex' => 'required|string|max:7',
            'nombre_color'     => 'required|string|max:100',
            'precio'           => 'required|numeric|min:0',
            'stock'            => 'required|integer|min:0',
            'disponible'       => 'boolean',
            'imagen_url'       => 'nullable|string',
        ]);

        $producto = Producto::create($validatedData);

        return response()->json([
            'message' => 'Producto creado con éxito',
            'data'    => $producto->load(['categoria', 'acabado']),
        ], 201);
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'acabado'])->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nombre'           => 'sometimes|required|string|max:255',
            'descripcion'      => 'nullable|string',
            'marca'            => 'nullable|string|max:100',
            'categoria_id'     => 'sometimes|required|exists:categorias,id',
            'acabado_id'       => 'sometimes|required|exists:acabados,id',
            'codigo_color_hex' => 'sometimes|required|string|max:7',
            'nombre_color'     => 'sometimes|required|string|max:100',
            'precio'           => 'sometimes|required|numeric|min:0',
            'stock'            => 'sometimes|required|integer|min:0',
            'disponible'       => 'boolean',
            'imagen_url'       => 'nullable|string',
        ]);

        $producto->update($validatedData);

        return response()->json([
            'message' => 'Producto actualizado con éxito',
            'data'    => $producto->load(['categoria', 'acabado']),
        ], 200);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
