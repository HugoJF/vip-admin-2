import React, {useEffect} from 'react';
import {postAuth} from "../actions/Auth";
import {toast} from "react-toastify";
import useRoutes from "../hooks/useRoutes";
import useBind from "../hooks/useBind";
import useRouter from "../hooks/useRouter";


export default function Login() {
    const auth = useBind(postAuth);
    const router = useRouter();
    const routes = useRoutes();

    useEffect(() => {
        handleLogin();
    }, []);

    async function handleLogin() {
        let data = await auth(router.location.search);

        if (data?.authed) {
            routes.home.redirect();

            toast.success(`Autenticado com sucesso!`)
        } else {
            toast.error('Error ao autenticar!');
        }
    }

    return <h1>Waiting for login...</h1>;
}