import React from 'react';
import CardDeck from "../ui/CardDeck";
import Card from "../ui/Card";
import useRoutes from "../../hooks/useRoutes";

export default function Home() {
    const routes = useRoutes();

    function features() {
        return <>
            <li>Acesso aos comandos <strong>!ws</strong>, <strong>!gloves</strong>, <strong>!knife</strong>;</li>
            <li><strong>Vaga garantida</strong> em todos os servidores;</li>
            <li><strong>Report prioritário</strong>;</li>
            <li>Tag <strong>[VIP]</strong> no chat e scoreboard.</li>
        </>
    }

    function createOrder(duration) {
        return () => {
            duration = duration.toString();
            routes.orders.create.redirect({duration})
        }
    }

    return (
        <>
            <h1 className="font-thin text-center text-5xl text-grey-darkest tracking-wide">VIPs por MercadoPago ou PayPal</h1>

            {/* Card deck */}
            <CardDeck>
                <Card
                    title="14 dias de VIP"
                    prefix="R$"
                    price="4,00"
                    onAction={createOrder(14)}
                >{features()}</Card>
                <Card
                    title="30 dias de VIP"
                    prefix="R$"
                    price="8,00"
                    highlight
                    onAction={createOrder(30)}
                >{features()}</Card>
                <Card
                    title="60 dias de VIP"
                    prefix="R$"
                    price="16,00"
                    onAction={createOrder(60)}
                >{features()}</Card>
            </CardDeck>
            <h1 className="font-thin text-center text-5xl text-grey-darkest tracking-wide">VIPs por Skins</h1>

            {/* Card deck */}
            <CardDeck>
                <Card
                    title="Sob demanda"
                    prefix="$"
                    price="0,08"
                    suffix="/dia"
                    onAction={createOrder(30)}
                >{features()}</Card>
            </CardDeck>
        </>
    );
}