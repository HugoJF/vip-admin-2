import React, {useEffect, useRef} from 'react';
import {addBreadcrumb, removeBreadcrumb} from "../actions/Breadcrumbs";
import {useDispatch} from 'redux-react-hook';

let globalId = 1;

export default function Breadcrumb({title, url, children}) {
    const idContainer = useRef(++globalId);
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(addBreadcrumb(idContainer.current, {title, url}));

        return () => {
            dispatch(removeBreadcrumb(idContainer.current));
        }
    }, [title, url]);

    return children;
}