import React, {Fragment} from 'react';
import Header from "./Header";
import Breadcrumbs from "./Breadcrumbs";
import Sidebar from "./Sidebar";

export default function DashboardContainer({children}) {
    return (
        <Fragment>
            <Header/>
            <div className="w-full">
                <main className="flex xl:flex-row flex-col flex-wrap">
                    <Sidebar/>

                    <main role="main" className="w-full xl:w-4/5 xl:ml-auto">
                        <Breadcrumbs/>

                        <div className="p-0 md:p-8">
                            {children}
                        </div>
                    </main>
                </main>
            </div>
        </Fragment>
    );
}