import React from 'react';
import {Link} from "react-router-dom";

export default function ({icon, title, onClick, to = '#', onHelpClick}) {
    return (
        <li className="flex justify-between my-2 ml-3">
            <Link to={to} onClick={onClick} className="flex items-center text-grey no-underline text-base group" href="#">
                <span className="trans-fast group-hover:text-white" data-feather={icon}/>
                <span className="trans-fast group-hover:text-grey-lightest">{title}</span>
            </Link>
            {
                onHelpClick &&
                <a onClick={onHelpClick} className="flex items-center group no-underline" href="#">
                    <span className="trans-fast group-hover:text-white" data-feather="help-circle"/>
                </a>
            }
        </li>
    );
}