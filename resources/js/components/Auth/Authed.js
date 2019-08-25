import React from 'react';
import useAuth from "../../hooks/useAuth";

/**
 * @return {null}
 */
export default function Authed({children}) {
    const auth = useAuth();

    return auth?.authed ? children : null;
}