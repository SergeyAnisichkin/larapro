<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminOrderSaveRequest;
use App\Models\Admin\Order;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\Request;
use MetaTag;

class OrderController extends AdminBaseController
{
    private $orderRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $perPage = 5;

        $countOrders = MainRepository::getCountOrders();
        $paginator = $this->orderRepository->getAllOrders($perPage);

        MetaTag::setTags(['title' => 'Список заказов']);

        return view('shop.admin.order.index',
            compact('countOrders', 'paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $item = $this->orderRepository->getEditId($id);
        if (empty($item)) {
            abort(404);
        }

        $order = $this->orderRepository->getOneOrder($item->id);
        if (!$order) {
            abort(404);
        }
        $order_products = $this->orderRepository->getAllOrderProductsId($item->id);

        MetaTag::setTags(['title' => "Заказ № {$item->id}"]);

        return view('shop.admin.order.edit',
            compact('item', 'order', 'order_products'));
    }


    public function change($id)
    {
        $result = $this->orderRepository->changeStatusOrder($id);

        if ($result) {
            return redirect()
                ->route('shop.admin.orders.edit', $id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $status = $this->orderRepository->changeStatusOnDelete($id);
        if ($status) {
            $result = Order::destroy($id);
            if ($result) {
                return redirect()
                    ->route('shop.admin.orders.index')
                    ->with(['success' => "Запись id [$id] удалена"]);
            } else {
                return back()->withErrors(['msg' => 'Ошибка удаления']);
            }
        } else {
            return back()->withErrors(['msg' => 'Статут не изменился']);
        }
    }

    /**
     * Полное удаление
     * @param $id
     */
    public function forcedestroy($id)
    {
        if (empty($id)){
            return back()->withErrors(['msg' => 'Запись не найдена']);
        }

        $res = \DB::table('orders')
            ->delete($id);

        if ($res) {
            return redirect()
                ->route('shop.admin.orders.index')
                ->with(['success' => "Запись id [$id] удалена из БД"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }


    public function save(AdminOrderSaveRequest $request, $id)
    {
        $result = $this->orderRepository->saveOrderComment($id);

        if ($result) {
            return redirect()
                ->route('shop.admin.orders.edit', $id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"]);
        }
    }
}
