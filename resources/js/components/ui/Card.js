import React from 'react';
import Button from "./Button";

export default function Card({
                                 highlight = false,
                                 title,
                                 price,
                                 prefix,
                                 onAction,
                                 suffix,
                                 children,
                             }) {
    return (
        <div className={`w-full lg:w-1/3 p-4 ${highlight ? 'scale-110' : ''}`}>
            {/* Card */}
            <div className={`flex flex-col text-grey-darkest border border-grey justify-between items-center shadow ${highlight ? 'shadow-lg' : 'shadow'} border-grey-darkest`}>
                {/* Header */}
                <div className="self-stretch py-3 border-b border-grey bg-grey-lighter">
                    <h2 className="font-normal text-center text-grey-darkest">{title}</h2>
                </div>

                {/* Body */}
                <div className="flex flex-col items-center p-8">
                    {/* Cost */}
                    <div>
                        <h4 className="flex items-baseline text-5xl">
                            <span className="mr-1 font-light text-grey-dark">{prefix}</span>
                            <span className="font-semibold text-grey-darkest">{price}</span>
                            <span className="mr-1 font-normal text-xl text-grey-dark">{suffix}</span>
                        </h4>
                    </div>

                    {/* Features */}
                    <ul className="my-8 list-reset text-center text-sm">
                        {children}
                    </ul>

                    {/* CTA */}
                    {
                        <Button
                            size="lg"
                            color="blue"
                            hollow={!highlight}
                            shadow3D={highlight}
                            onClick={onAction}
                        >Comprar</Button>
                    }
                </div>
            </div>
        </div>
    );
}
