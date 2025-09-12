--
-- PostgreSQL database dump
--

-- Dumped from database version 14.18 (Homebrew)
-- Dumped by pg_dump version 14.18 (Homebrew)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: achievements; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.achievements (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    goal_id uuid NOT NULL,
    title character varying(255) NOT NULL,
    description text NOT NULL,
    certificate_message text NOT NULL,
    affirmation_message text NOT NULL,
    certificate_number character varying(255) NOT NULL,
    achievement_date date NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.achievements OWNER TO bagaspra16;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO bagaspra16;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO bagaspra16;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.categories (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    color character varying(255) DEFAULT '#3498db'::character varying NOT NULL,
    description text,
    user_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO bagaspra16;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO bagaspra16;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: bagaspra16
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO bagaspra16;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bagaspra16
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: goals; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.goals (
    id uuid NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    start_date date NOT NULL,
    end_date date NOT NULL,
    priority character varying(255) DEFAULT 'medium'::character varying NOT NULL,
    progress_percent integer DEFAULT 0 NOT NULL,
    category_id uuid NOT NULL,
    user_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    status character varying(255) DEFAULT 'not_started'::character varying NOT NULL,
    CONSTRAINT goals_priority_check CHECK (((priority)::text = ANY ((ARRAY['low'::character varying, 'medium'::character varying, 'high'::character varying])::text[]))),
    CONSTRAINT goals_status_check CHECK (((status)::text = ANY ((ARRAY['not_started'::character varying, 'in_progress'::character varying, 'completed'::character varying, 'finished'::character varying, 'abandoned'::character varying])::text[])))
);


ALTER TABLE public.goals OWNER TO bagaspra16;

--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO bagaspra16;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO bagaspra16;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: bagaspra16
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jobs_id_seq OWNER TO bagaspra16;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bagaspra16
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: journals; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.journals (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    date date NOT NULL,
    title character varying(100),
    content text NOT NULL,
    mood character varying(255) DEFAULT 'calm'::character varying NOT NULL,
    tags json,
    category character varying(255) DEFAULT 'Personal'::character varying NOT NULL,
    important boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT journals_category_check CHECK (((category)::text = ANY ((ARRAY['Personal'::character varying, 'Social'::character varying, 'Career'::character varying, 'Spiritual'::character varying, 'Academic'::character varying, 'Health'::character varying, 'Finance'::character varying, 'Hobby'::character varying])::text[]))),
    CONSTRAINT journals_mood_check CHECK (((mood)::text = ANY ((ARRAY['happy'::character varying, 'sad'::character varying, 'anxious'::character varying, 'calm'::character varying, 'angry'::character varying, 'confused'::character varying, 'excited'::character varying, 'tired'::character varying, 'satisfied'::character varying, 'frustrated'::character varying])::text[])))
);


ALTER TABLE public.journals OWNER TO bagaspra16;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO bagaspra16;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: bagaspra16
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO bagaspra16;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bagaspra16
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO bagaspra16;

--
-- Name: progress; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.progress (
    id uuid NOT NULL,
    note text NOT NULL,
    progress_value integer NOT NULL,
    goal_id uuid,
    task_id uuid,
    user_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.progress OWNER TO bagaspra16;

--
-- Name: sessions; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id uuid,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO bagaspra16;

--
-- Name: tasks; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.tasks (
    id uuid NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    due_date date,
    priority character varying(255) DEFAULT 'medium'::character varying NOT NULL,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    completed_at timestamp(0) without time zone,
    goal_id uuid NOT NULL,
    user_id uuid NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    start_time timestamp(0) without time zone,
    completed_time timestamp(0) without time zone,
    duration_minutes integer,
    force_complete_reason text,
    CONSTRAINT tasks_priority_check CHECK (((priority)::text = ANY ((ARRAY['low'::character varying, 'medium'::character varying, 'high'::character varying])::text[]))),
    CONSTRAINT tasks_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'in_progress'::character varying, 'completed'::character varying])::text[])))
);


ALTER TABLE public.tasks OWNER TO bagaspra16;

--
-- Name: users; Type: TABLE; Schema: public; Owner: bagaspra16
--

CREATE TABLE public.users (
    id uuid NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    avatar character varying(255),
    bio text,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    two_factor_secret character varying(255),
    two_factor_enabled boolean DEFAULT false NOT NULL,
    last_login_at timestamp(0) without time zone,
    last_login_ip character varying(255),
    last_login_user_agent character varying(255),
    failed_login_attempts integer DEFAULT 0 NOT NULL,
    locked_until timestamp(0) without time zone,
    security_question character varying(255),
    security_answer character varying(255),
    trusted_devices json,
    password_changed_at timestamp(0) without time zone,
    email_verified boolean DEFAULT false NOT NULL,
    email_verification_token character varying(255)
);


ALTER TABLE public.users OWNER TO bagaspra16;

--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Data for Name: achievements; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.achievements (id, user_id, goal_id, title, description, certificate_message, affirmation_message, certificate_number, achievement_date, status, created_at, updated_at, deleted_at) FROM stdin;
048f0392-eedc-43d4-92f9-38ae1c495e34	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	Goal Completion: Pray 5 times a day consistently	Successfully completed the goal "Pray 5 times a day consistently" with 100% progress.	# Certificate of Achievement Congratulations, Beck! Your commitment to praying five times a day consistently is a remarkable achievement that reflects your dedication and spiritual growth. May this journey inspire you to continue reaching new heights in your faith and personal development! Keep shining your light.	Every goal I complete strengthens my belief in my abilities and propels me toward even greater success.	CERT-202509-A3E2D8	2025-09-04	active	2025-09-04 18:58:19	2025-09-04 18:58:19	\N
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.cache (key, value, expiration) FROM stdin;
temperance_cache_5c785c036466adea360111aa28563bfd556b5fba:timer	i:1757396764;	1757396764
temperance_cache_5c785c036466adea360111aa28563bfd556b5fba	i:1;	1757396764
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.categories (id, name, color, description, user_id, created_at, updated_at, deleted_at) FROM stdin;
b68fc913-9460-4ff4-a380-a739fe053023	Exercise	#114aa7	Develop my exercise timing better...	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 00:17:40	2025-08-20 00:17:40	\N
619eff49-4841-4689-bea8-b6a70b906050	Health	#10b981	Develop my healty life to be ten times better	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 00:18:52	2025-08-20 00:18:52	\N
40e1c350-7da1-4073-8bcb-63dcebf8519f	Learning	#80c8ff	Develop my learning time & life cycle	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 00:22:25	2025-08-20 00:22:25	\N
08bfd982-96fd-4e30-a724-ac581be44c64	Saving	#f59e0b	Maintai my saving everyday to get a better goals	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 00:24:58	2025-08-20 00:24:58	\N
121451cb-4296-4b7e-a643-b1d053cb3d61	Spiritual	#ffffff	Maintain my spiritual life to be better	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 00:31:22	2025-08-20 00:31:22	\N
f962c1c4-6683-49fe-9512-766e7f285246	Working	#ef4444	Develop my working time go get balancing to the other	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 09:15:50	2025-08-20 09:15:50	\N
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: goals; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.goals (id, title, description, start_date, end_date, priority, progress_percent, category_id, user_id, created_at, updated_at, deleted_at, status) FROM stdin;
e0cf1541-a8b7-4b2e-b733-d637099c10a8	Eat & drink no/less sugar	Eating & drinking less sugar for a better life cycle & better quality of sleep	2025-08-20	2025-08-29	medium	0	619eff49-4841-4689-bea8-b6a70b906050	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:50:01	2025-08-20 01:50:01	\N	not_started
af1c28c5-e739-4202-89a1-6f5c5fb52858	First 10 grand by only saving	Achieve my first 10 grand with my money only with saving	2025-08-20	2025-12-30	medium	0	08bfd982-96fd-4e30-a724-ac581be44c64	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:51:54	2025-08-20 01:51:54	\N	not_started
42646716-64be-4afd-8aac-152c39235243	Learning AI specificly	Try to learning AI specificly and with more rescource & information	2025-08-20	2025-09-30	medium	0	40e1c350-7da1-4073-8bcb-63dcebf8519f	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:54:22	2025-08-20 01:54:22	\N	not_started
23930d78-f117-491f-998a-28af163aa3be	Learning psychology general & specific	Learning psychology using books or E-Books, and resource from YouTube	2025-08-20	2025-10-30	medium	0	40e1c350-7da1-4073-8bcb-63dcebf8519f	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:56:01	2025-08-20 01:56:01	\N	not_started
57dbf093-f129-4736-b886-45541e3d6fe4	Get more certificate in Tech, AI, & Cyber Security	Try to achieve certificate from any learning path to get a better & much certificate as my portfolio	2025-08-20	2025-11-30	high	0	40e1c350-7da1-4073-8bcb-63dcebf8519f	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:57:46	2025-08-20 01:57:46	\N	not_started
030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	Pray 5 times a day consistently	Try to do pray 5 times a day consistenly without any excuse	2025-08-20	2025-08-29	high	100	121451cb-4296-4b7e-a643-b1d053cb3d61	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:47:51	2025-09-04 18:58:03	\N	finished
92a7a519-702c-49c8-9f82-19e8f7562720	Work efficiently every weekdays	Try to work efficiently every weekdays to get better time of work	2025-08-20	2025-12-30	medium	100	f962c1c4-6683-49fe-9512-766e7f285246	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 10:33:07	2025-08-21 21:53:35	\N	completed
5cf32b61-9b53-4f37-b612-8a065fbc4233	Hit a workout 3-4 times a week	Try to hit a workout at least for 3-4 times a week	2025-08-20	2025-08-24	high	100	b68fc913-9460-4ff4-a380-a739fe053023	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:41:46	2025-08-21 21:54:11	\N	completed
c479b318-f5e0-4f8a-bb75-24f4a18c33cd	Sleep straight for 7 hours	Try to sleep better within 7 hours estimate	2025-08-20	2025-08-29	high	100	619eff49-4841-4689-bea8-b6a70b906050	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:46:13	2025-08-21 06:00:03	\N	completed
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: journals; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.journals (id, user_id, date, title, content, mood, tags, category, important, created_at, updated_at, deleted_at) FROM stdin;
685e6c0b-5d23-4db7-9055-4c18f7f74954	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21	Start over everything	Yesterday i felt so excited, cause i starting my day using this app after a long development, for a first time i use this app without any development concern anymore, i felt so ready with everything that i can get better, i setup everyting like categories, goals, and start over my task with sleep with a better time, and getting next with doing my exercise in morning, and also maintain my praying time in this app, i felt so gratefull this app could help me with tracking my life style to get better, my times of working also being my concern, so i also tracking it in this app and it feels so amazing, i love that, i hope i could get ready for a mobile development this app and getting release ASAP using mobile to get more easier dan better tracking. So, see ya to the next journal that i would write about.	satisfied	["newdays","startover","excited"]	Personal	t	2025-08-21 00:02:48	2025-08-21 00:06:18	\N
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_07_02_181030_create_categories_table	1
5	2025_07_02_181037_create_goals_table	1
6	2025_07_02_181043_create_tasks_table	1
7	2025_07_02_181049_create_progress_table	1
8	2025_07_21_012509_add_duration_to_tasks_table	2
9	2025_07_21_130944_add_time_tracking_columns_to_tasks_table	3
10	2025_07_26_045917_add_finished_status_to_goals_table	4
11	2025_07_26_053648_create_achievements_table	5
13	2025_07_31_091210_create_journals_table	6
14	2025_08_19_072232_create_reminders_table	7
15	2025_08_19_103053_create_reminders_table	8
16	2025_09_09_104852_add_security_columns_to_users_table	9
17	2025_09_09_104911_create_security_audit_logs_table	10
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: progress; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.progress (id, note, progress_value, goal_id, task_id, user_id, created_at, updated_at) FROM stdin;
2eb90238-9ed1-4663-b8a7-a7d71ebf1f9d	Task started	25	\N	ff043e34-4e14-4c56-85d7-7ffc957f01f7	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 02:00:34	2025-08-20 02:00:34
1328293e-0c47-4321-8556-410d76e32fbb	Task completed	100	\N	ff043e34-4e14-4c56-85d7-7ffc957f01f7	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 07:17:09	2025-08-20 07:17:09
3876720e-46b4-402a-ba77-1709b0f730f0	Task started	25	\N	29560833-fde2-4fd6-8bea-d17ee26f79d8	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 08:32:09	2025-08-20 08:32:09
b4307d6d-ad89-4b43-92f3-208dc808c0d2	Task completed	100	\N	29560833-fde2-4fd6-8bea-d17ee26f79d8	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 09:14:44	2025-08-20 09:14:44
886f8b93-d73f-448a-931b-7f3de5e1b570	Task started	25	\N	6b434696-6f21-463f-aa37-3717763dac89	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 09:23:08	2025-08-20 09:23:08
22aabda9-0106-4f67-b7ff-06b0228ff283	Task completed	100	\N	6b434696-6f21-463f-aa37-3717763dac89	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 09:25:04	2025-08-20 09:25:04
3da010cf-9b23-419a-bc8a-74e8b2c1cd5e	Task started	25	\N	6eca835c-54e5-4b46-b43a-c4b4e5e32015	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 10:33:42	2025-08-20 10:33:42
613d5ea8-e783-4172-b890-cb2b89150ec2	Task started	25	\N	4ccfee91-abe5-40df-afa0-4fc2486d6fed	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 15:43:13	2025-08-20 15:43:13
7ca776d9-6ed5-433b-99f5-27b96306bde2	Task completed	100	\N	4ccfee91-abe5-40df-afa0-4fc2486d6fed	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 16:07:06	2025-08-20 16:07:06
43b423bc-b496-4e3d-a0f4-1e39e2573953	Task completed	100	\N	6eca835c-54e5-4b46-b43a-c4b4e5e32015	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 17:32:15	2025-08-20 17:32:15
9fefaaa5-fed1-4722-8307-f552a60a7993	Task started	25	\N	8b32cbf1-f30d-46ca-9ebb-a334caa7cbcb	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 19:01:04	2025-08-20 19:01:04
2ee34189-ef19-4f5b-8ac0-4b62a633dacc	Task completed	100	\N	8b32cbf1-f30d-46ca-9ebb-a334caa7cbcb	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 19:17:40	2025-08-20 19:17:40
6d46bbe2-df8e-4b8b-9b69-16a15f82ac72	Task force-completed: I have done my isha but i forgot to start my task	100	\N	7d1adcdd-6876-4a80-bf30-00230427157f	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 19:18:38	2025-08-20 19:18:38
88577f5d-591a-4798-b189-041784c8a4f5	Task started	25	\N	87e50c40-85dc-4031-8e6a-d4c9d0ad1526	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 00:18:29	2025-08-21 00:18:29
999ce51c-a8ac-4da6-a3e4-49e56da5005c	Task completed	100	\N	87e50c40-85dc-4031-8e6a-d4c9d0ad1526	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 06:00:03	2025-08-21 06:00:03
287f65ee-484b-44c3-b0c8-8fe912637317	Task started	25	\N	574fccb6-b34f-4dca-99ff-326116d01ed9	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 08:23:40	2025-08-21 08:23:40
7c04805a-5bc9-4fd6-bc3a-849ce8081285	Task completed	100	\N	574fccb6-b34f-4dca-99ff-326116d01ed9	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 08:26:32	2025-08-21 08:26:32
fa9c2c9e-8e68-44ab-866a-246ff9b0e299	Task started	25	\N	433b7fce-0243-4853-a8c1-31384324fd60	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 09:46:28	2025-08-21 09:46:28
d9ff4fa8-2440-42a1-a57a-a213e8784d62	Task force-completed: I already did that, but forgot to mention it that time	100	\N	a3a4f0f4-691a-439f-9962-138b03516f17	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 21:52:10	2025-08-21 21:52:10
8b140b75-9af2-4dd3-8dac-dcf0011cb8f9	Task force-completed: Already did that, but can't play it at that time	100	\N	8e577ff0-ec27-4c51-9951-45dff216a704	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 21:52:55	2025-08-21 21:52:55
f5e13305-69d5-4d2e-9b95-f32e702eaebf	Task force-completed: Same reason as the maghrib, cause i did that after maghrib	100	\N	74a2b386-2586-45b7-b23f-8244b3ff1c5d	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 21:53:24	2025-08-21 21:53:24
1c781797-3841-473d-8a53-20175a4bb44b	Task completed	100	\N	433b7fce-0243-4853-a8c1-31384324fd60	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 21:53:35	2025-08-21 21:53:35
8c41f8d1-1d1e-4e76-80a3-2fae1fa51fc7	Task force-completed: I already hit a gym with my friends in work	100	\N	9624e35e-b9a6-458e-a4de-b433210c4454	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 21:54:11	2025-08-21 21:54:11
31f22d98-4fa7-4de5-b0ec-01bb87474d84	Task force-completed: I have done shubuh already	100	\N	7cfab325-9f72-400e-b585-d8db8bb36039	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-25 07:23:16	2025-08-25 07:23:16
5d026329-ba39-453d-9893-7ced909613dd	Task force-completed: I have done my shubuh this day erlier	100	\N	6212b058-11f9-43fc-9747-24a099d108cf	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-28 10:01:08	2025-08-28 10:01:08
ffb687db-4dad-43aa-a8cf-73aa3a68f6cf	Task force-completed: i have done my shubuh today earlier	100	\N	df6bc41e-2e93-4091-bcee-dc9d3bd61fdb	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-09-04 12:42:00	2025-09-04 12:42:00
ff609d6f-d6d6-404e-b94c-c9de6baa73c4	Task force-completed: i'm done with this	100	\N	619d6ba7-d8e9-4673-a8e9-764bc53c0975	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-09-04 18:57:18	2025-09-04 18:57:18
fdd049ba-3eb7-4b86-94a9-30ca52c43a81	Task force-completed: i'm done with this task	100	\N	0c8b51ba-ddf4-469f-9459-d9e467a6fe10	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-09-04 18:57:31	2025-09-04 18:57:31
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
yqgEr5bjsBS2NWqSOd0CFJDS9Yr3PuNb0Q2aX7Sr	\N	127.0.0.1	Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36	YToyOntzOjY6Il90b2tlbiI7czo0MDoiVzRvZUtaREpTWlE3am83VFllNXBZcVFCRm1QZTRWZ1U3RUxnNGwwViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1757664464
sZoXXbQN5lDUPdosUFiI0N3sSQJmfk980HpzMwJt	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	127.0.0.1	Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZXJaRlRNbDRJV1RJa0RBb25ndkdCeE9WUjZDWXdrejZjcUZxV1ZlbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6IjZlYmY3ODQ4LTVmMGUtNDBmZi1hN2E3LTAwOTkxYTgxYzZkZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319	1757666911
\.


--
-- Data for Name: tasks; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.tasks (id, title, description, due_date, priority, status, completed_at, goal_id, user_id, created_at, updated_at, deleted_at, start_time, completed_time, duration_minutes, force_complete_reason) FROM stdin;
57ae334f-bb6a-4dee-8dc2-ea5dc805b165	Pray dzuhur	I have pray dzuhur this day	2025-08-21	medium	pending	\N	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 07:01:28	2025-08-21 21:52:16	2025-08-21 21:52:16	\N	\N	\N	\N
ff043e34-4e14-4c56-85d7-7ffc957f01f7	Sleep more 4/5 hours to get better	Try to sleep 4/5 hours to finish my time of sleep & not getting sick anymore	2025-08-20	medium	completed	2025-08-20 07:17:09	c479b318-f5e0-4f8a-bb75-24f4a18c33cd	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 01:59:58	2025-08-20 07:17:09	\N	2025-08-20 02:00:34	2025-08-20 07:17:09	317	\N
8e577ff0-ec27-4c51-9951-45dff216a704	Pray maghrib	I pray maghrib today	2025-08-21	medium	completed	2025-08-21 21:52:55	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 07:03:09	2025-08-21 21:52:55	\N	\N	2025-08-21 21:52:55	0	Already did that, but can't play it at that time
29560833-fde2-4fd6-8bea-d17ee26f79d8	Morning simple workout	I need to do simple morning workout today before i work	2025-08-20	medium	completed	2025-08-20 09:14:44	5cf32b61-9b53-4f37-b612-8a065fbc4233	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 08:32:04	2025-08-20 09:14:44	\N	2025-08-20 08:32:09	2025-08-20 09:14:44	43	\N
74a2b386-2586-45b7-b23f-8244b3ff1c5d	Pray isha	i have pray isha today	2025-08-21	medium	completed	2025-08-21 21:53:24	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 07:03:32	2025-08-21 21:53:24	\N	\N	2025-08-21 21:53:24	0	Same reason as the maghrib, cause i did that after maghrib
6b434696-6f21-463f-aa37-3717763dac89	Pray shubuh	Today i did pray shubuh but felt late	2025-08-20	high	completed	2025-08-20 09:25:04	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 09:23:03	2025-08-20 09:25:04	\N	2025-08-20 09:23:08	2025-08-20 09:25:04	2	\N
433b7fce-0243-4853-a8c1-31384324fd60	Work more better this day	Try to work more better time this day, cause i have something to finish	2025-08-21	medium	completed	2025-08-21 21:53:35	92a7a519-702c-49c8-9f82-19e8f7562720	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 19:38:21	2025-08-21 21:53:35	\N	2025-08-21 09:46:28	2025-08-21 21:53:35	728	\N
9624e35e-b9a6-458e-a4de-b433210c4454	Take any exercise this day	Take any exercise i like to do like working out, jogging, basket, whatever it is	2025-08-21	high	completed	2025-08-21 21:54:11	5cf32b61-9b53-4f37-b612-8a065fbc4233	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 07:07:46	2025-08-21 21:54:11	\N	\N	2025-08-21 21:54:11	0	I already hit a gym with my friends in work
4ccfee91-abe5-40df-afa0-4fc2486d6fed	Pray ashar	I have to do pray ashar	2025-08-20	high	completed	2025-08-20 16:07:06	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 15:42:57	2025-08-20 16:07:06	\N	2025-08-20 15:43:13	2025-08-20 16:07:06	24	\N
6eca835c-54e5-4b46-b43a-c4b4e5e32015	Work better today	Try to working better this day	2025-08-20	medium	completed	2025-08-20 17:32:15	92a7a519-702c-49c8-9f82-19e8f7562720	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 10:33:38	2025-08-20 17:32:15	\N	2025-08-20 10:33:42	2025-08-20 17:32:15	419	\N
8b32cbf1-f30d-46ca-9ebb-a334caa7cbcb	Pray maghrib	I pray mghrib this time	2025-08-20	high	completed	2025-08-20 19:17:40	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 18:04:11	2025-08-20 19:17:40	\N	2025-08-20 19:01:04	2025-08-20 19:17:40	17	\N
7d1adcdd-6876-4a80-bf30-00230427157f	Pray isha	I have did pray my isha	2025-08-20	high	completed	2025-08-20 19:18:38	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-20 19:18:11	2025-08-20 19:18:38	\N	\N	2025-08-20 19:18:38	0	I have done my isha but i forgot to start my task
7cfab325-9f72-400e-b585-d8db8bb36039	Pray shubuh	I have done my first shubuh in dormitory	2025-08-25	medium	completed	2025-08-25 07:23:16	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-25 07:22:51	2025-08-25 07:23:16	\N	\N	2025-08-25 07:23:16	0	I have done shubuh already
87e50c40-85dc-4031-8e6a-d4c9d0ad1526	Sleep for a least 5-6 hours	Try to sleep better for a 5-6 hours straight to get better result for everyday	2025-08-21	medium	completed	2025-08-21 06:00:03	c479b318-f5e0-4f8a-bb75-24f4a18c33cd	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 00:18:20	2025-08-21 06:00:03	\N	2025-08-21 00:18:29	2025-08-21 06:00:03	342	\N
6212b058-11f9-43fc-9747-24a099d108cf	Pray shubuh	i have pray shubuh this day.	2025-08-28	medium	completed	2025-08-28 10:01:08	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-28 10:00:46	2025-08-28 10:01:08	\N	\N	2025-08-28 10:01:08	0	I have done my shubuh this day erlier
574fccb6-b34f-4dca-99ff-326116d01ed9	Pray shubuh	i need to pray shubuh as always	2025-08-21	medium	completed	2025-08-21 08:26:32	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 07:00:52	2025-08-21 08:26:32	\N	2025-08-21 08:23:40	2025-08-21 08:26:32	3	\N
a3a4f0f4-691a-439f-9962-138b03516f17	Pray ashar	I really2 need to pray ashar	2025-08-21	high	completed	2025-08-21 21:52:10	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-08-21 07:02:34	2025-08-21 21:52:10	\N	\N	2025-08-21 21:52:10	0	I already did that, but forgot to mention it that time
df6bc41e-2e93-4091-bcee-dc9d3bd61fdb	Pray shubuh	i have done my shubuh today	2025-09-04	medium	completed	2025-09-04 12:42:00	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-09-04 12:41:40	2025-09-04 12:42:00	\N	\N	2025-09-04 12:42:00	0	i have done my shubuh today earlier
619d6ba7-d8e9-4673-a8e9-764bc53c0975	Pray dzuhur	i have done my dzuhur	2025-09-04	medium	completed	2025-09-04 18:57:18	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-09-04 18:56:43	2025-09-04 18:57:18	\N	\N	2025-09-04 18:57:18	0	i'm done with this
0c8b51ba-ddf4-469f-9459-d9e467a6fe10	Pray maghrib	i've done my maghrib this day	2025-09-04	medium	completed	2025-09-04 18:57:31	030a3cb2-7b9b-4c42-8c85-6a6bfc36233a	6ebf7848-5f0e-40ff-a7a7-00991a81c6de	2025-09-04 18:57:08	2025-09-04 18:57:31	\N	\N	2025-09-04 18:57:31	0	i'm done with this task
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: bagaspra16
--

COPY public.users (id, name, email, email_verified_at, password, avatar, bio, remember_token, created_at, updated_at, deleted_at, two_factor_secret, two_factor_enabled, last_login_at, last_login_ip, last_login_user_agent, failed_login_attempts, locked_until, security_question, security_answer, trusted_devices, password_changed_at, email_verified, email_verification_token) FROM stdin;
6ebf7848-5f0e-40ff-a7a7-00991a81c6de	Beck	iambeck16@temperance.com	\N	$2y$12$NIRi1NR86UVgj4VY46IR2euRc7XzdUe24OYrFFVW1bgUpVYnAieHS	avatars/eaB78az8G12co9IlK3sB8viI7SQt7sjf1gnsUXEf.jpg	try to be better next time.	NFu62K1Te1DuHjkJarXacYzfOUebW53PFHc78FC6Lxj1fPqPrKh6ZrQ6dWWw	2025-07-07 20:37:30	2025-08-19 02:55:20	\N	\N	f	\N	\N	\N	0	\N	\N	\N	\N	\N	f	\N
\.


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bagaspra16
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bagaspra16
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bagaspra16
--

SELECT pg_catalog.setval('public.migrations_id_seq', 17, true);


--
-- Name: achievements achievements_certificate_number_unique; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.achievements
    ADD CONSTRAINT achievements_certificate_number_unique UNIQUE (certificate_number);


--
-- Name: achievements achievements_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.achievements
    ADD CONSTRAINT achievements_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: goals goals_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.goals
    ADD CONSTRAINT goals_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: journals journals_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.journals
    ADD CONSTRAINT journals_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: progress progress_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.progress
    ADD CONSTRAINT progress_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tasks tasks_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: bagaspra16
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: bagaspra16
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: bagaspra16
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: achievements achievements_goal_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.achievements
    ADD CONSTRAINT achievements_goal_id_foreign FOREIGN KEY (goal_id) REFERENCES public.goals(id) ON DELETE CASCADE;


--
-- Name: achievements achievements_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.achievements
    ADD CONSTRAINT achievements_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: categories categories_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: goals goals_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.goals
    ADD CONSTRAINT goals_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- Name: goals goals_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.goals
    ADD CONSTRAINT goals_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: journals journals_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.journals
    ADD CONSTRAINT journals_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: progress progress_goal_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.progress
    ADD CONSTRAINT progress_goal_id_foreign FOREIGN KEY (goal_id) REFERENCES public.goals(id) ON DELETE CASCADE;


--
-- Name: progress progress_task_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.progress
    ADD CONSTRAINT progress_task_id_foreign FOREIGN KEY (task_id) REFERENCES public.tasks(id) ON DELETE CASCADE;


--
-- Name: progress progress_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.progress
    ADD CONSTRAINT progress_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: tasks tasks_goal_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_goal_id_foreign FOREIGN KEY (goal_id) REFERENCES public.goals(id) ON DELETE CASCADE;


--
-- Name: tasks tasks_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: bagaspra16
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

