import React from 'react';
import useAuth from "../../hooks/useAuth";
import useIsAdmin from "../../hooks/useIsAdmin";

/**
 * @return {null}
 */
export default function Authed({children}) {
    const isAdmin = useIsAdmin();

    return isAdmin ? children : null;
}