import React, {useState} from 'react';
import Button from "../ui/Button";
import {Spinner} from "reactstrap";
import {toast} from 'react-toastify';
import useRoutes from "../../hooks/useRoutes";
import {postOrder} from "../../actions/Orders";
import useBind from "../../hooks/useBind";

export default function OrderCreation({duration}) {
    const postOrder = useBind(postOrder);
    const routes = useRoutes();

    const [loading, setLoading] = useState(false);

    function handlePostOrder(autoActivation) {
        setLoading(true);

        postOrder({duration, autoActivation})
            .then((data) => {
                routes.orders.redirect.redirect({orderId: data.id});
            })
            .catch((e) => {
                toast.error(`Erro ao gerar pedido: ${e}`);
            })
            .then(() => {
                setLoading(false);
            });
    }

    return (
        <>
            <div className="flex flex-col items-center">
                <div className="px-32">
                    <h1>Continuar com auto-ativação?</h1>

                    <h3 className="my-8 text-center font-light">A auto-ativação permite que nosso sistema automáticamente ative e sincronize seu pedido assim que detectado como pago. </h3>
                    <p className="my-8 text-center"><strong>Recomendamos que desative a auto-ativação no caso de pagamentos por Boleto Bancário ou com contas da Steam sem SteamGuard</strong>, desta forma você pode manualmente ativar o pedido em outro momento e <strong>evitar perder dias que você não pode jogar</strong>.</p>

                    <div className="flex justify-center">
                        {
                            loading
                                ?
                                <Spinner className="h-16 w-16"/>
                                :
                                <>
                                    <Button
                                        size="lg"
                                        color="blue"
                                        onClick={handlePostOrder.bind(this, true)}
                                    >Sim, manter ativado</Button>
                                    <Button
                                        size="lg"
                                        color="white"
                                        border={['t', 'r', 'b']}
                                        onClick={handlePostOrder.bind(this, false)}
                                    >Não, desativar</Button>
                                </>
                        }
                    </div>
                </div>
            </div>
        </>
    );
}