import React, {useState} from 'react';
import {paymentUrl} from "../../constants/variables";
import useInterval from '@use-it/interval';

export default function OrderRedirect({order}) {
    const [interval, setInterval] = useState(100);
    const [delay, setDelay] = useState(5000);

    useInterval(() => {
        waitForRedirect();
    }, interval);

    function waitForRedirect() {
        setDelay(delay - 100);

        if (delay < 0) {
            setInterval(null);
            setDelay(0);
            redirectToPayment();
        }
    }

    function redirectToPayment() {
        window.location = `${paymentUrl}orders/${order.reference}`;
    }

    return (
        <h1>Redirecionando para o gateway de pagamento em {(delay / 1000).toFixed(0)} segundos...</h1>
    );
}