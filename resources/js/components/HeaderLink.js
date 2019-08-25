import React from 'react';
import {Link} from "react-router-dom";
import Icon from "./ui/Icon";

export default function HeaderLink({to, title, icon, onClick, href}) {
    function getLink() {
        return (
            <a href={href} onClick={onClick} className="trans p-3 no-underline cursor-pointer hover:bg-grey-darker">
                <Icon classes="text-grey-light" icon={icon}/>
                <span className="text-grey-light">{title}</span>
            </a>
        )
    }

    return (
        to
            ?
            <Link to={to}>
                {getLink()}
            </Link>
            :
            getLink()
    );
}