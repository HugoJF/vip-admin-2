import React, {useEffect} from 'react';
import OrdersTable from "./OrdersTable";
import TokensTable from "./TokensTable";
import useFastState from "../../hooks/useFastState";
import useBind from "../../hooks/useBind";
import {search as searchAction} from "../../actions/Search";

export default function Search({term}) {
    const _search = useBind(searchAction);
    const search = useFastState('search');

    const {orders, tokens} = search.results || {};
    const {loading} = search;

    useEffect(() => {
        if (!loading)
            _search(term);
    }, []);

    return (
        <>
            <OrdersTable
                loading={loading}
                orders={Object.values(orders || {})}
            />
            <TokensTable
                loading={loading}
                tokens={Object.values(tokens || {})}
            />
        </>
    );
}