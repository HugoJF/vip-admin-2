import React, {Fragment} from 'react';
import Icon from "./ui/Icon";
import {Link} from "react-router-dom";
import useFastState from "../hooks/useFastState";

export default function Breadcrumbs() {
    const breadcrumbs = useFastState('breadcrumbs');

    return (
        <div className="py-3 px-8 bg-grey-lighter border-b border-grey-light shadow-inner">
            <Link to="/"><span className="text-grey-dark">Home</span></Link>
            {Object.values(breadcrumbs).map((b) => (
                <Fragment key={'breadcrumbs' + b.title}>
                    <Icon icon="chevron-right"/>
                    <Link to={b.url}><span className="text-grey-dark">{b.title}</span></Link>
                </Fragment>
            ))}
        </div>
    );
}