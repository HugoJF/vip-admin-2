import React, {useState, useEffect} from 'react';
import OrdersTable from "./OrdersTable";
import {getOrders} from "../../actions/Orders";
import Order from "./Order";
import Breadcrumb from "../Breadcrumb";
import OrderRedirect from "./OrderRedirect";
import OrderCreation from "./OrderCreation";
import useReactRouter from 'use-react-router';
import useFastState from "../../hooks/useFastState";
import useBind from "../../hooks/useBind";
import {Route} from "react-router-dom";
import useAsyncEffect from "../../hooks/useAsyncEffect";

export default function Orders() {
    const _getOrders = useBind(getOrders);
    const router = useReactRouter();
    const [loading, setLoading] = useState(false);

    const orders = useFastState('orders');

    useAsyncEffect(async () => {
        setLoading(true);
        await _getOrders();
        setLoading(false);
    }, []);

    const {match} = router;

    // TODO: use useRoutes to define routes?
    return (
        <>
            <Route
                path={`${match.url}`}
                exact
                render={() => (
                    <OrdersTable
                        loading={loading}
                        orders={orders.allIds.map(id => orders.byId[id])}
                    />
                )}
            />
            <Route
                path={`${match.url}/creating/:duration?`}
                render={({match}) => (
                    <Breadcrumb title={`${match.params.duration} dias`} url={match.url}>
                        <OrderCreation
                            duration={parseInt(match.params.duration)}
                        />
                    </Breadcrumb>
                )}
            />
            <Route
                path={`${match.url}/:orderId/redirect`}
                exact
                render={({match}) => (
                    <Breadcrumb title={`Order #${match.params.orderId}`} url={match.url}>
                        <OrderRedirect
                            order={orders.byId[match.params.orderId]}
                        />
                    </Breadcrumb>
                )}
            />
            <Route
                path={`${match.url}/:orderId`}
                exact
                render={({match}) => (
                    <Breadcrumb title={`Order #${match.params.orderId}`} url={match.url}>
                        <Order
                            order={orders.byId[match.params.orderId]}
                        />
                    </Breadcrumb>
                )}
            />
        </>
    );
}