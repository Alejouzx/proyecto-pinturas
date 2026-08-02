<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function receive(Request $request)
    {
        $entry = $request->input('entry')[0] ?? null;
        $message = $entry['changes'][0]['value']['messages'][0] ?? null;

        if (!$message) {
            return response()->json(['status' => 'ok'], 200);
        }

        $from = $message['from'];
        $text = strtolower(trim($message['text']['body'] ?? ''));

        $respuesta = $this->generarRespuesta($text);

        Log::info("WhatsApp de $from: $text -> $respuesta");

        return response()->json([
            'to' => $from,
            'text' => $respuesta,
        ]);
    }

    private function generarRespuesta(string $texto): string
    {
        if (preg_match('/\b(hola|buenos días|buenas tardes|hey)\b/i', $texto)) {
            return "¡Hola! 🎨 Soy el asistente de Acrilinco. Puedes preguntarme por:\n- Catálogo de productos\n- Buscar por color (ej: 'color azul')\n- Buscar por categoría (ej: 'vinilo')\n- Precios de un producto\n- Productos disponibles";
        }

        if (preg_match('/#([0-9A-Fa-f]{6})/', $texto, $matches)) {
            $hex = '#' . strtoupper($matches[1]);
            $productos = Producto::where('codigo_color_hex', $hex)->get();
            return $this->formatearListaProductos($productos, "Productos con color $hex");
        }

        if (preg_match('/\bcolor\s+(\w+)\b/i', $texto, $matches)) {
            $color = $matches[1];
            $productos = Producto::where('nombre_color', 'ilike', "%$color%")
                          ->orWhere('codigo_color_hex', 'ilike', "%$color%")
                          ->get();
            return $this->formatearListaProductos($productos, "Resultados para '$color'");
        }

        foreach (['vinilo', 'esmalte', 'impermeabilizante'] as $cat) {
            if (stripos($texto, $cat) !== false) {
                $productos = Producto::whereHas('categoria', function ($q) use ($cat) {
                    $q->where('nombre', 'ilike', "%$cat%");
                })->get();
                return $this->formatearListaProductos($productos, "Productos de $cat");
            }
        }

        return "No entendí tu consulta. 🤔\nPrueba con:\n- 'color azul'\n- 'vinilo'\n- '#033380'\n- 'catálogo'";
    }

    private function formatearListaProductos($productos, string $titulo): string
    {
        if ($productos->isEmpty()) {
            return "❌ No encontré productos para: $titulo";
        }

        $respuesta = "✅ *$titulo*\n";
        foreach ($productos->take(5) as $p) {
            $respuesta .= "- {$p->nombre} ({$p->nombre_color}) | \${$p->precio} | Stock: {$p->stock}\n";
        }
        if ($productos->count() > 5) {
            $respuesta .= "\n... y " . ($productos->count() - 5) . " más.";
        }
        return $respuesta;
    }
}