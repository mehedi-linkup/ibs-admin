<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Order;
use App\Models\OrderData;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\OrderDetailsData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return view('pages.order.index');
    }

    public function getOrder()
    {
        if(Auth::user()->factory_id != null){
            return Order::with(['buyer' => function($b) {
                $b->select('id', 'name');
            }, 'merchant' => function($m) {
                $m->select('id', 'name');
            }, 'factory' => function($f) {
                $f->select('id', 'name');
            }])->where('factory_id', Auth::user()->factory_id)->get();
        } else if (Auth::user()->merchant_id != null) {
            return Order::with(['buyer' => function($b) {
                $b->select('id', 'name');
            }, 'merchant' => function($m) {
                $m->select('id', 'name');
            }, 'factory' => function($f) {
                $f->select('id', 'name');
            }])->where('merchant_id', Auth::user()->merchant_id)->get();
        } else if(Auth::user()->gm != null) {
            return Order::with(['buyer' => function($b) {
                $b->select('id', 'name');
            }, 'merchant' => function($m) {
                $m->select('id', 'name');
            }, 'factory' => function($f) {
                $f->select('id', 'name');
            }])->where('gm', Auth::user()->gm)->get();
        } else {
            return Order::with(['buyer' => function($b) {
                $b->select('id', 'name');
            }, 'merchant' => function($m) {
                $m->select('id', 'name');
            }, 'factory' => function($f) {
                $f->select('id', 'name');
            }])->get();
        }
    }

    public function saveOrder(Request $request)
    {
        $res = new stdClass();
        try {
            $order = new Order();
            $order->buyer_id = $request->buyer_id;
            $order->style_description = $request->style_description;
            $order->style_number = $request->style_number;
            $order->merchant_id = $request->merchant_id;
            $order->factory_id = $request->factory_id;
            $order->gm = $request->gm;
            $order->user_id = Auth::user()->id;
            $order->user_ip = $request->ip();
            $order->save();
            $res->message = 'Order Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function updateOrder(Request $request)
    {
        $res = new stdClass();
        try {
            $order = Order::findOrFail($request->id);
            $order->buyer_id = $request->buyer_id;
            $order->style_description = $request->style_description;
            $order->style_number = $request->style_number;
            $order->merchant_id = $request->merchant_id;
            $order->factory_id = $request->factory_id;
            $order->gm = $request->gm;
            $order->user_id = Auth::user()->id;
            $order->user_ip = $request->ip();
            $order->save();
            $res->message = 'Order Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteOrder(Request $request)
    {
        $res = new stdClass();
        try {
            $order = Order::find($request->id);
            $order->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function AddOrderData(Request $request)
    {
        // return $request->all();
        $res = new stdClass();
        try {
            foreach($request->order as $value){
                $orderData = new OrderData();
                $orderData->item_name = $value['item_name'];
                $orderData->supplier_id = $value['supplier_id'];
                $orderData->description = $value['description'];
                $orderData->order_id = $request->orderId;
                $orderData->user_id = Auth::user()->id;
                $orderData->user_ip = $request->ip();
                $orderData->save();
            }
            $res->message = 'Successfully Saved !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function OrderDataList() 
    {
        return view('pages.order.orderData');
    }

    public function getOrderData()
    {
        if(Auth::user()->factory_id != null){
            return OrderData::whereHas('order', function($or){
                    $or->where('factory_id', Auth::user()->factory_id);
                })->with(['order', 'supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'order.factory' => function($of) {
                    $of->select('id', 'name');
                }
            ])->latest()->get();
        } else if(Auth::user()->merchant_id != null) {
            return OrderData::whereHas('order', function($or){
                    $or->where('merchant_id', Auth::user()->merchant_id);
                })->with(['order', 'supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'order.factory' => function($of) {
                    $of->select('id', 'name');
                }
            ])->latest()->get();
        } else if(Auth::user()->gm != null) {
            return OrderData::whereHas('order', function($or){
                    $or->where('gm', Auth::user()->gm);
                })->with(['order', 'supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'order.factory' => function($of) {
                    $of->select('id', 'name');
                }
            ])->latest()->get();
        } else {
            return OrderData::with(['order', 'supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'order.factory' => function($of) {
                    $of->select('id', 'name');
                }
            ])->latest()->get();
        }
    }

    public function UpdateOrderData(Request $request)
    {
        // return $request->all();
        $res = new stdClass();
        try {
            $orderData = OrderData::find($request->id);
            $orderData->item_name = $request->item_name;
            $orderData->supplier_id = $request->supplier_id;
            $orderData->description = $request->description;
            $orderData->order_id = $orderData->order_id;
            $orderData->user_id = Auth::user()->id;
            $orderData->user_ip = $request->ip();
            $orderData->save();
            $res->message = 'Successfully Updated !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }


    public function deleteOrderData(Request $request)
    {
        $res = new stdClass();
        try {
            $order_data = OrderData::find($request->id);
            $order_data->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function OrderDetails()
    {
        return view('pages.order.orderDetails');
    }
    
    public function OrderDetailsSave(Request $request)
    {
        // dd($request->orderDetails);
        $res = new stdClass();
        try {
            foreach($request->orderDetails as $value) {
                $orderDetails = new OrderDetails();
                $orderDetails->order_data_id = $request->OrderDataId;
                $orderDetails->order_number = $value['order_number'];
                $orderDetails->shipment_date = $value['shipment_date'];
                $orderDetails->color_id = $value['color_id'];
                $orderDetails->size = $value['size'];
                $orderDetails->order_qty = $value['order_qty'];
                $orderDetails->unit_id = $value['unit_id'];
                // $orderDetails->pt_received = $value['pt_received'];
                // $orderDetails->payment_date = $value['payment_date'];
                $orderDetails->tentative_in_house_date = $value['tentative_in_house_date'];
                // $orderDetails->received_qty = $value['received_qty'];
                // $orderDetails->remaining_qty = $value['remaining_qty'];
                // $orderDetails->in_house_date = $value['in_house_date'];
                // $orderDetails->task = $value['task'];
                $orderDetails->user_id = Auth::user()->id;
                $orderDetails->user_ip = $request->ip();
                $orderDetails->save();
                $res->message = 'Order Details Saved !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function getOrderDetails()
    {
        if (Auth::user()->factory_id != null) {
            return OrderDetails::whereHas('orderData.order', function($od) {
                    $od->where('factory_id', Auth::user()->factory_id);
                })->with(['orderData', 'orderData.order',
                'orderData.supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'orderData.order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'orderData.order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'orderData.order.factory' => function($of) {
                    $of->select('id', 'name');
                }, 'color' => function($c) {
                    $c->select('id', 'name');
                }, 'unit' => function($u) {
                    $u->select('id', 'name');
                }])->withCount(['orderDetailsDatas as order_details_quantity' => function($odq){
                    $odq->select(DB::raw('ifnull(SUM(quantity), 0)'));
            }])->latest()->get();
        } else if(Auth::user()->merchant_id != null) {
            return OrderDetails::whereHas('orderData.order', function($od) {
                    $od->where('merchant_id', Auth::user()->merchant_id);
                })->with(['orderData', 'orderData.order',
                'orderData.supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'orderData.order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'orderData.order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'orderData.order.factory' => function($of) {
                    $of->select('id', 'name');
                }, 'color' => function($c) {
                    $c->select('id', 'name');
                }, 'unit' => function($u) {
                    $u->select('id', 'name');
                }])->withCount(['orderDetailsDatas as order_details_quantity' => function($odq){
                    $odq->select(DB::raw('ifnull(SUM(quantity), 0)'));
            }])->latest()->get();
        } else if(Auth::user()->gm != null) {
            return OrderDetails::whereHas('orderData.order', function($od) {
                    $od->where('gm', Auth::user()->gm);
                })->with(['orderData', 'orderData.order',
                'orderData.supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'orderData.order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'orderData.order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'orderData.order.factory' => function($of) {
                    $of->select('id', 'name');
                }, 'color' => function($c) {
                    $c->select('id', 'name');
                }, 'unit' => function($u) {
                    $u->select('id', 'name');
                }])->withCount(['orderDetailsDatas as order_details_quantity' => function($odq){
                    $odq->select(DB::raw('ifnull(SUM(quantity), 0)'));
            }])->latest()->get();
        } else {
            return OrderDetails::with(['orderData', 'orderData.order',
                'orderData.supplier' => function($s) {
                    $s->select('id', 'name');
                }, 'orderData.order.buyer' => function($ob) {
                    $ob->select('id', 'name');
                }, 'orderData.order.merchant' => function($om) {
                    $om->select('id', 'name');
                }, 'orderData.order.factory' => function($of) {
                    $of->select('id', 'name');
                }, 'color' => function($c) {
                    $c->select('id', 'name');
                }, 'unit' => function($u) {
                    $u->select('id', 'name');
                }])->withCount(['orderDetailsDatas as order_details_quantity' => function($odq){
                    $odq->select(DB::raw('ifnull(SUM(quantity), 0)'));
            }])->latest()->get();
        }
    }

    public function updateOrderDetails(Request $request)
    {
        $res = new stdClass();
        try {
            $orderDetails = OrderDetails::find($request->id);
            $orderDetails->order_data_id = $orderDetails->order_data_id;
            $orderDetails->order_number = $request->order_number;
            $orderDetails->shipment_date = $request->shipment_date;
            $orderDetails->color_id = $request->color_id;
            $orderDetails->size = $request->size;
            $orderDetails->order_qty = $request->order_qty;
            $orderDetails->unit_id = $request->unit_id;
            $orderDetails->pt_received = $request->pt_received;
            $orderDetails->payment_date = $request->payment_date;
            $orderDetails->tentative_in_house_date = $request->tentative_in_house_date;
            // $orderDetails->received_qty = $request->received_qty;
            // $orderDetails->remaining_qty = $request->remaining_qty;
            $orderDetails->in_house_date = $request->in_house_date;
            $orderDetails->task = $request->task;
            $orderDetails->user_id = Auth::user()->id;
            $orderDetails->user_ip = $request->ip();
            $orderDetails->save();
            $res->message = 'Order Details Updated !!';
            
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteOrderDetails(Request $request)
    {
        $res = new stdClass();
        try {
            $order_details = OrderDetails::find($request->id);
            $order_details->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function SaveOrderDetailsData(Request $request) 
    {
        $res = new stdClass();
        try {
            foreach($request->order as $value){
                $orderDetailsData = new OrderDetailsData();
                $orderDetailsData->order_details_id = $request->orderDetailsId;
                $orderDetailsData->date = $value['date'];
                $orderDetailsData->receive_date = $value['receive_date'];
                $orderDetailsData->quantity = $value['quantity'];
                $orderDetailsData->chalan_number = $value['chalan_number'];
                $orderDetailsData->user_id = Auth::user()->id;
                $orderDetailsData->user_ip = $request->ip();
                $orderDetailsData->save();
            }
            $res->message = 'Successfully Saved !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);   
    }

    public function OrderSearch()
    {
        return view('pages.order.search');
    }
    public function OrderFilter()
    {
        return view('pages.order.filter');
    }

    public function getSearchResult(Request $request) 
    {
        $clauses = "";

        if(isset($request->buyerId)) {
            $clauses .= " and o.buyer_id = $request->buyerId";
        }

        if(isset($request->factoryId)) {
            $clauses .= " and  o.factory_id = $request->factoryId";
        }

        if(isset($request->supplierId)) {
            $clauses .= " and  oda.supplier_id = $request->supplierId";
        }

        if($request->dateFrom != '' && $request->dateTo != '') {
            $clauses .= " and date(od.created_at) between '$request->dateFrom' and '$request->dateTo'";
        }
        $orders = DB::select("
            select 
                od.*,
                c.name as color,
                u.name as unit,
                oda.order_id,
                oda.item_name,
                oda.description,
                oda.supplier_id,
                o.style_description,
                o.style_number,
                o.gm,
                o.buyer_id,
                o.factory_id,
                o.merchant_id,
                o.merchant_id,
                s.name as supplier,
                b.name as buyer,
                m.name as merchant,
                f.name as factory
            from order_details od
            join order_data oda on oda.id = od.order_data_id
            join colors c on c.id = od.color_id
            join units u on u.id = od.unit_id
            join orders o on o.id = oda.order_id
            join suppliers s on s.id = oda.supplier_id
            join buyers b on b.id = o.buyer_id
            join merchants m on m.id = o.merchant_id
            join factories f on f.id = o.factory_id
            where od.deleted_at is null
            $clauses
        ");
        return $orders;
    }

    public function OrderDetailsData()
    {
        return view('pages.order.orderDetailsData');
    }

    public function getOrderDetailsData()
    {
        if(Auth::user()->factory_id != null) {
            return OrderDetailsData::whereHas('orderDetails.orderData.order', function($or) {
                $or->where('factory_id', Auth::user()->factory_id);
            })->with('orderDetails')->latest()->get();
        } else if(Auth::user()->merchant_id != null) {
            return OrderDetailsData::whereHas('orderDetails.orderData.order', function($or) {
                $or->where('merchant_id', Auth::user()->merchant_id);
            })->with('orderDetails')->latest()->get();
        } else if(Auth::user()->gm != null) {
            return OrderDetailsData::whereHas('orderDetails.orderData.order', function($or) {
                $or->where('gm', Auth::user()->gm);
            })->with('orderDetails')->latest()->get();
        } else {
            return OrderDetailsData::with('orderDetails')->latest()->get();
        }
    }

    public function UpdateOrderDetailsData(Request $request)
    {
        $res = new stdClass();
        try {
            $orderDetailsData =  OrderDetailsData::find($request->id);
            $orderDetailsData->order_details_id = $orderDetailsData->order_details_id;
            $orderDetailsData->date = $request->date;
            $orderDetailsData->receive_date = $request->receive_date;
            $orderDetailsData->quantity = $request->quantity;
            $orderDetailsData->chalan_number = $request->chalan_number;
            $orderDetailsData->user_id = Auth::user()->id;
            $orderDetailsData->user_ip = $request->ip();
            $orderDetailsData->save();
            $res->message = 'Order Details Data Update !!';
        } catch (\Exception $e) {
            $res->message = 'Faield'. $e->getMessage();
        }
        return response(['message' => $res->message]);
    }

    public function DeleteOrderDetailsData(Request $request)
    {
        $res = new stdClass();
        try {
            $order_details_data = OrderDetailsData::find($request->id);
            $order_details_data->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
