<?php

namespace App\Http\Controllers\Api;

use App\Models\Venda;
use App\Models\Celular;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CadastrarNovaVendaRequest;
use App\Http\Requests\ConsultarVendaEspecificaRequest;
use App\Http\Requests\CancelarVendaRequest;
use App\Http\Requests\CadastrarNovosProdutosRequest;
use App\Http\Requests\RemoverProdutoRequest;

class VendaController extends Controller
{

    public function listarProdutosDisponiveis()
    {
        $celulares = Celular::select('id', 'name', 'price', 'description')->get();

        if($celulares->isEmpty()){
            return response()->json(['message' => 'Nenhum produto disponível'], 404);
        }

        return response()->json($celulares, 200);
    }

    public function cadastrarNovaVenda(CadastrarNovaVendaRequest $request)
    {
        $celulares = $request->get('celulares');
        $venda = new Venda();
        $produtos = [];

        foreach ($celulares as $celularData) {
            $celular = Celular::find($celularData['id']);

            if($celular == null){
                return response()->json(['message' => 'Celular não encontrado'], 404);
            }

            $venda->amount += $celular->price * $celularData['quantidade'];
            $produtos[] = [
                'name' => $celular->name,
                'price' => $celular->price,
                'amount' => $celularData['quantidade'],
                'product_id' => $celular->id
            ];
        }

        $venda->products = json_encode($produtos);
        $venda->save();

        return response()->json(['message' => 'Venda cadastrada com sucesso', 'venda_id' => $venda->id], 201);
    }

    public function consultarVendasRealizadas()
    {
        $vendas = Venda::all();

        if($vendas->isEmpty()){
            return response()->json(['message' => 'Nenhuma venda realizada'], 404);
        }

        return response()->json($vendas, 200);
    }

    public function consultarVendaEspecifica($sales_id)
    {
        $venda = Venda::where('sales_id', $sales_id)->first();

        if($venda == null){
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        return response()->json($venda, 200);
    }

    public function cancelarVenda($sales_id)
    {
        $venda = Venda::where('sales_id', $sales_id)->first();

        if($venda == null){
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $venda->where('sales_id', $sales_id)->delete();

        return response()->json(['message' => 'Venda cancelada com sucesso'], 200);
    }

    public function cadastrarNovosProdutos(CadastrarNovosProdutosRequest $request, $sales_id)
    {
        $venda = Venda::where('sales_id', $sales_id)->first();

        if($venda == null){
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $celulares = $request->get('celulares');
        $produtos = is_array($venda->products) ? $venda->products : json_decode($venda->products, true);

        foreach ($celulares as $celularData) {
            $celular = Celular::where('id', $celularData['id'])->first();

            if($celular == null){
                return response()->json(['message' => 'Celular não encontrado'], 404);
            }

            $venda->amount += $celular->price * $celularData['quantidade'];
            $produtos[] = [
                'name' => $celular->name,
                'price' => $celular->price,
                'amount' => $celularData['quantidade'],
                'product_id' => $celular->id
            ];
        }

        $venda->products = json_encode($produtos);
        $venda->where('sales_id', $sales_id)->update(['products' => $venda->products, 'amount' => $venda->amount]);

        return response()->json(['message' => 'Celulares adicionados com sucesso'], 200);
    }

    public function removerProduto(RemoverProdutoRequest $request, $sales_id)
    {
        $venda = Venda::where('sales_id', $sales_id)->first();

        if($venda == null){
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $produtoId = $request->get('produto_id');
        $produtos = is_array($venda->products) ? $venda->products : json_decode($venda->products, true);

        $produtoRemovido = null;
        foreach ($produtos as $key => $produto) {
            if ($produto['product_id'] == $produtoId) {
                $produtoRemovido = $produto;
                unset($produtos[$key]);
                break;
            }
        }

        if ($produtoRemovido === null) {
            return response()->json(['message' => 'Produto não encontrado na venda'], 404);
        }

        $venda->amount +=  $venda->amount - $produtoRemovido['price'];
        $venda->products = json_encode(array_values($produtos));
        $venda->where('sales_id', $sales_id)->update(['products' => $venda->products, 'amount' => $venda->amount]);

        return response()->json(['message' => 'Produto removido com sucesso'], 200);
    }
}
