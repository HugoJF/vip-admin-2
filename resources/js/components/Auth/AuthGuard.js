import React, {useState, useEffect, useRef} from "react";
import {getAuth as _getAuth, refreshAuth as _refreshAuth} from "../../actions/Auth";
import jwtDecode from "jwt-decode";
import moment from "moment/moment";
import {secondsBeforeRefresh} from "../../constants/variables";
import useInterval from '@use-it/interval';
import useAuth from "../../hooks/useAuth";
import useBind from "../../hooks/useBind";
import {Route} from 'react-router-dom';

export default function AuthGuard({children}) {
    const [loading, setLoading] = useState(false);
    const tokenContainer = useRef(undefined);
    const getAuth = useBind(_getAuth);
    const refreshAuth = useBind(_refreshAuth);

    const auth = useAuth();

    useEffect(() => {
        getAuth();
    }, []);

    useInterval(() => {
        check();
    }, 10000);

    function setup() {
        if (auth?.authed) return false;
        if (!tokenContainer.current) decodeToken();

        return true;
    }

    function decodeToken() {
        tokenContainer.current = jwtDecode(auth?.token);
    }

    function check() {
        if (!setup()) return;
        if (loading) return;
        if (!tokenContainer?.current?.exp) return;

        let expiration = tokenContainer?.current?.exp;
        let delta = expiration - moment().unix();

        console.log('Seconds remaining for token expiration: ', delta);
        if (delta < secondsBeforeRefresh) {
            setLoading(true);
            refreshAuth().then(() => {
                decodeToken();
                setLoading(false);
            });
        }
    }

    return children;
}