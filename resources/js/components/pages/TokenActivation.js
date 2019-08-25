import React, {useState, useEffect} from 'react';
import Button from "../ui/Button";
import Stand from "../ui/Stand";
import StandRow from "../ui/StandRow";
import StandLabel from "../ui/StandLabel";
import StandValue from "../ui/StandValue";
import {storeToken, useToken} from "../../actions/Tokens";
import {toast} from 'react-toastify';
import {Spinner} from "reactstrap";
import useBind from "../../hooks/useBind";
import useRoutes from "../../hooks/useRoutes";

export default function TokenActivation({token}) {
    const [loading, setLoading] = useState(false);
    const routes = useRoutes();
    const _useToken = useBind(useToken);
    const _storeToken = useBind(storeToken);

    useEffect(() => {
        if (token?.order_id)
            redirectToOrder(token?.order_id);
    }, []);

    function redirectToOrder(orderId) {
        routes.orders.show.redirect({orderId});
    }

    async function handleUseToken() {
        setLoading(true);
        try {
            let data = await _useToken(token.id);
            await _storeToken(data);
            redirectToOrder(data.order_id);
        } catch (e) {
            toast.error(`Erro ao utilizar token: ${e.message}`);
        }
    }

    return (
        <>
            <h1>Token #{token.id}</h1>

            <div className="flex w-full justify-center">
                <div className="w-128">
                    <p className="text-center">{token?.note}</p>
                </div>
            </div>

            <div className="my-10">
                <Stand>
                    <StandRow>
                        <StandLabel>Duração</StandLabel>
                        <StandValue>{token?.duration} dias</StandValue>
                    </StandRow>
                </Stand>
            </div>

            <div className="flex w-full justify-center items-center">
                {loading && <Spinner size="lg" className="mr-2"/>}
                <div className="w-64">
                    <Button onClick={handleUseToken} color="green" size="lg" shadow3D={true}>
                        Usar token
                    </Button>
                </div>
            </div>
        </>
    );
}