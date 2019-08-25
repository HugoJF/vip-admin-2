import React from 'react';
import useFastState from "../../hooks/useFastState";

/**
 * @return {null}
 */
export default function Guest({children}) {
    const auth = useFastState('auth');

    return auth?.authed ? null : children;
}
