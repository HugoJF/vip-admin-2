import React, {useState} from 'react';
import TableHead from "../tables/TableHead";
import TableBody from "../tables/TableBody";
import TableHeader from "../tables/TableHeader";
import Table from "../tables/Table";
import OrderEditionModal from "../modal/OrderEditionModal";
import {toast} from 'react-toastify';
import columns from './OrdersTableColumns'
import useRoutes from "../../hooks/useRoutes";
import useModal from "../../hooks/useModal";
import useUser from "../../hooks/useUser";
import {activatesOrder} from "../../actions/Orders";
import useBind from "../../hooks/useBind";
import {ORDER_EDIT} from "../../constants/Modals";

export default function OrdersTable({orders, loading = true}) {
    const _activatesOrder = useBind(activatesOrder);
    const routes = useRoutes();

    const [editionOrder, setEditionOrder] = useState(null);
    const [openOrderEdition, closeOrderEdition, isOrderEditionOpen] = useModal(ORDER_EDIT);

    const user = useUser();

    function handleActivatesOrder(data) {
        _activatesOrder(data.id)
            .then((data) => {
                toast.success(`Pedido #${data.id} ativado!`)
            })
            .catch((e) => {
                toast.error(`Erro ao ativar pedido: ${e.message}`)
            });
    }


    function onToggleEditModal(order) {
        setEditionOrder(order);
        openOrderEdition();
    }

    function redirectToDetails(order) {
        routes.orders.show.redirect({orderId: order.id});
    }

    let cols = columns({onToggleEditModal, redirectToDetails, handleActivatesOrder});

    let adminColumns = ['id', 'username', 'duration', 'created_at', 'state', 'actions'];
    let userColumns = ['id', 'duration', 'created_at', 'state', 'actions'];
    let dataToDisplay = (user?.admin) ? adminColumns : userColumns;

    return <>
        <h1>Pedidos</h1>

        <OrderEditionModal open={isOrderEditionOpen} order={editionOrder}/>

        <Table>
            <TableHead columns={dataToDisplay.map(data => cols[data].header)}>
                {
                    (head) => <TableHeader key={head}>{head}</TableHeader>
                }
            </TableHead>
            <TableBody colSpan={dataToDisplay.length} loading={loading} dataKey="id" data={Object.values(orders)}>
                {
                    (data) => dataToDisplay.map(o => cols[o].render(data))
                }
            </TableBody>
        </Table>
    </>;
}